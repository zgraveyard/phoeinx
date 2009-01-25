<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     html_select_date_adv
 * File:     functions.html_select_date_adv.php
 * Version:  0.10
 * Purpose:  Prints the dropdowns for date selection like html_select_date with added features
 * Author:   Bill Wheaton <billwheaton atsign mindspring fullstop com>
 * Acknowledgements: Thanks to Andrei Zmievski, Monte, Jan Rosier, Gary Loescher, Marcus Bointon
 *              for their work on the original html_select_date on which this is based.
 *              Thanks also for letting me learn that a field can be named 'blah[xxx]' and
 *              end up in $_REQUEST as a hash. That is so fly.
 * Description: html_select_date_adv is a direct and backward compatable replacement
 *  of html_select_date.  It adds extra features, hence the '_adv' extention
 *  The extra feature params are:
 *      suffix - a hash with keys 'day', 'month', 'year' and corresponding values
 *          for the field_array naming scheme.  default values are 'Day', 'Month', 'Year'
 *          if not supplied. eg:
 *       ***{assign_adv
 *              var=date_field_names
 *              value="array('day'=>'day','month'=>'month','year'=>'year')"}
 *          {html_select_date_adv field_array='eventymd' prefix='' suffix=$date_field_names ...
 *          will create
 *              <select name="eventymd[month]"> rather than the default
 *              <select name="eventymd[Month]">
 *          and the same for the year and day selects.
 *          if prefix is given it will be prepended like normal.
 *          *** note the wierd syntax of assign_adv. it allows assigning arrays.
 *              see function.assign_adv.php for details
 *      month_first_opt - hash of values/displayvalues to put before the
 *          monthvalues/monthnames in the options list.
 *          Allows the month field to contain e.g., the first pair of ''/Please Choose Month
 *      month_first_opt_selected - if set to a value, including '', this overrides the
 *          calculated selected value from $time.  This lets the designer select something
 *          besides value of the time param or its default, nowtime.  setting it to '' would
 *          select the first display value, 'Please Choose Month'.
 *      day_first_opt, day_first_opt_selected, year_first_opt, year_first_opt_selected -
 *          similar in nature to month_first_opt and month_first_opt_selected
 *
 * Requires: function.html_options_adv.php and optionally function.assign_adv.php (for assigning arrays)
 * See Also: function.html_select_time_adv.php for similar changes
 *           function.html_field_group.php for advanced creation of radio _and_ checkbox groups
 *
 * ChangeLog: beta 0.10 first release (Bill Wheaton)
 *
 * COPYRIGHT:
 *     Copyright (c) 2003 Bill Wheaton
 *     This software is released under the GNU Lesser General Public License.
 *     Please read the following disclaimer
 *
 *      THIS SOFTWARE IS PROVIDED ''AS IS'' AND ANY EXPRESSED OR IMPLIED
 *      WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 *      OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 *      DISCLAIMED.  IN NO EVENT SHALL THE AUTHOR OR CONTRIBUTORS BE
 *      LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY,
 *      OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT
 *      OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
 *      OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 *      LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *      NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *      SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *     See the GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * -------------------------------------------------------------
 */
function smarty_function_html_select_date_adv($params, &$smarty)
{
    require_once $smarty->_get_plugin_filepath('shared','make_timestamp');
    require_once $smarty->_get_plugin_filepath('function','html_options_adv');
    /* Default values. */
    $prefix          = "Date_";
    $suffix          = array('day'=>'Day','month'=>'Month','year'=>'Year');
    $start_year      = strftime("%Y");
    $end_year        = $start_year;
    $display_days    = true;
    $display_months  = true;
    $display_years   = true;
    $month_format    = "%B";
    /* Write months as numbers by default  GL */
    $month_value_format = "%m";
    $day_format      = "%02d";
    /* Write day values using this format MB */
    $day_value_format = "%d";
    $year_as_text    = false;
    /* Display years in reverse order? Ie. 2000,1999,.... */
    $reverse_years   = false;
    /* Should the select boxes be part of an array when returned from PHP?
       e.g. setting it to "birthday", would create "birthday[Day]",
       "birthday[Month]" & "birthday[Year]". Can be combined with prefix */
    $field_array     = null;
    /* <select size>'s of the different <select> tags.
       If not set, uses default dropdown. */
    $day_size        = null;
    $month_size      = null;
    $year_size       = null;
    /* Unparsed attributes common to *ALL* the <select>/<input> tags.
       An example might be in the template: all_extra ='class ="foo"'. */
    $all_extra       = null;
    /* Separate attributes for the tags. */
    $day_extra       = null;
    $month_extra     = null;
    $year_extra      = null;
    /* Order in which to display the fields.
       "D" -> day, "M" -> month, "Y" -> year. */
    $field_order      = 'MDY';
    /* String printed between the different fields. */
    $field_separator = "\n";
    $time = time();
    $month_first_opt = null;
    $day_first_opt = null;
    $year_first_opt = null;
    $month_first_opt_selected = null;
    $day_first_opt_selected = null;
    $year_first_opt_selected = null;



    extract($params);
    // If $time is not in format yyyy-mm-dd
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $time)) {
        // then $time is empty or unix timestamp or mysql timestamp
        // using smarty_make_timestamp to get an unix timestamp and
        // strftime to make yyyy-mm-dd
        $time = strftime('%Y-%m-%d', smarty_make_timestamp($time));
    }
    // Now split this in pieces, which later can be used to set the select
    $time = explode("-", $time);

    // make syntax "+N" or "-N" work with start_year and end_year
    if (preg_match('!^(\+|\-)\s*(\d+)$!', $end_year, $match)) {
        if ($match[1] == '+') {
            $end_year = strftime('%Y') + $match[2];
        } else {
            $end_year = strftime('%Y') - $match[2];
        }
    }
    if (preg_match('!^(\+|\-)\s*(\d+)$!', $start_year, $match)) {
        if ($match[1] == '+') {
            $start_year = strftime('%Y') + $match[2];
        } else {
            $start_year = strftime('%Y') - $match[2];
        }
    }

    $field_order = strtoupper($field_order);

    $html_result = $month_result = $day_result = $year_result = "";

    if ($display_months) {
        $month_names = array();
        $month_values = array();

        for ($i = 1; $i <= 12; $i++) {
            $month_names[] = strftime($month_format, mktime(0, 0, 0, $i, 1, 2000));
            $month_values[] = strftime($month_value_format, mktime(0, 0, 0, $i, 1, 2000));
        }

        $month_result .= '<select name=';
        if (null !== $field_array){
            $month_result .= '"' . $field_array . '[' . $prefix . "${suffix[month]}]\"";
        } else {
            $month_result .= '"' . $prefix . "${suffix[month]}\"";
        }
        if (null !== $month_size){
            $month_result .= ' size="' . $month_size . '"';
        }
        if (null !== $month_extra){
            $month_result .= ' ' . $month_extra;
        }
        if (null !== $all_extra){
            $month_result .= ' ' . $all_extra;
        }
        $month_result .= '>'."\n";

        $month_result .= smarty_function_html_options_adv(array('output'     => $month_names,
                                                            'values'     => $month_values,
                                                            'first_opt'  => $month_first_opt,
                                                            'selected'   => isset($month_first_opt_selected) ? $month_first_opt_selected : $month_values[$time[1]-1],
                                                            'print_result' => false),
                                                      $smarty);

        $month_result .= '</select>';
    }

    if ($display_days) {
        $days = array();
        for ($i = 1; $i <= 31; $i++) {
            $days[] = sprintf($day_format, $i);
            $day_values[] = sprintf($day_value_format, $i);
        }

        $day_result .= '<select name=';
        if (null !== $field_array){
            $day_result .= '"' . $field_array . '[' . $prefix . "${suffix[day]}]\"";
        } else {
            $day_result .= '"' . $prefix . "${suffix[day]}\"";
        }
        if (null !== $day_size){
            $day_result .= ' size="' . $day_size . '"';
        }
        if (null !== $all_extra){
            $day_result .= ' ' . $all_extra;
        }
        if (null !== $day_extra){
            $day_result .= ' ' . $day_extra;
        }
        $day_result .= '>'."\n";
        $day_result .= smarty_function_html_options_adv(array('output'     => $days,
                                                          'values'     => $day_values,
                                                          'first_opt'  => $day_first_opt,
                                                          'selected'   => isset($day_first_opt_selected) ? $day_first_opt_selected : $time[2],
                                                          'print_result' => false),
                                                    $smarty);
        $day_result .= '</select>';
    }

    if ($display_years) {
        if (null !== $field_array){
            $year_name = $field_array . '[' . $prefix . "${suffix[year]}]";
        } else {
            $year_name = $prefix . $suffix[year];
        }
        if ($year_as_text) {
            $year_result .= '<input type="text" name="' . $year_name . '" value="' . $time[0] . '" size="4" maxlength="4"';
            if (null !== $all_extra){
                $year_result .= ' ' . $all_extra;
            }
            if (null !== $year_extra){
                $year_result .= ' ' . $year_extra;
            }
            $year_result .= '>';
        } else {
            $years = range((int)$start_year, (int)$end_year);
            if ($reverse_years) {
                rsort($years, SORT_NUMERIC);
            }

            $year_result .= '<select name="' . $year_name . '"';
            if (null !== $year_size){
                $year_result .= ' size="' . $year_size . '"';
            }
            if (null !== $all_extra){
                $year_result .= ' ' . $all_extra;
            }
            if (null !== $year_extra){
                $year_result .= ' ' . $year_extra;
            }
            $year_result .= '>'."\n";
            $year_result .= smarty_function_html_options_adv(array('output' => $years,
                                                               'values' => $years,
                                                               'first_opt' => $year_first_opt,
                                                               'selected'   => isset($year_first_opt_selected) ? $year_first_opt_selected : $time[0],
                                                               'print_result' => false),
                                                         $smarty);
            $year_result .= '</select>';
        }
    }

    // Loop thru the field_order field
    for ($i = 0; $i <= 2; $i++){
      $c = substr($field_order, $i, 1);
      switch ($c){
        case 'D':
            $html_result .= $day_result;
            break;

        case 'M':
            $html_result .= $month_result;
            break;

        case 'Y':
            $html_result .= $year_result;
            break;
      }
      // Add the field seperator
      if($i != 2) {
        $html_result .= $field_separator;
      }
    }

    return $html_result;
}

/* vim: set expandtab: */

?>
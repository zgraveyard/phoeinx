<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     html_options_adv
 * File:     function.html_options_adv.php
 * Version:  0.10
 * Purpose:  Prints the list of <option> tags generated from
 *           the passed parameters optionally surrounded by select tags.
 *           Optionally inserts supplied <option> tags before the others
 * Author:   Bill Wheaton <billwheaton atsign mindspring fullstop com>
 * Acknowledgements: Thanks to whoever wrote html_options for their original
 *           work on which this is based.
 * Synopsis:
 *      {html_options_adv
 *          name="_select"
 *          values=$optionsarray
 *          output=$displayarray
 *          selected=$optionsarray[0]
 *          first_op=$first_opt_hash}
 *      where the only difference between html_options and html_options_adv is the first_op param
 *      which is a hash of value/display values to be inserted before the others
 *
 * Description: html_select_date and html_select_time had no way to add extra options to their
 *      select fields to indicate a condition that no month was selected for example.
 *      modifications there required a change here to facilitate that ability.
 *
 * Input:      name       (optional) - string default "select"
 *             values     (required if no options supplied) - array
 *             options    (required if no values supplied) - associative array
 *             selected   (optional) - string default not set
 *             output     (required if not options supplied) - array
 *             first_opt  (optional (new)) - array hash of value/display value pairs to be
 *                                      inserted before the other <option> tags.
 *
 * See Also: function.html_select_time_adv.php
 *           function.html_select_date_adv.php
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
function smarty_function_html_options_adv($params, &$smarty)
{
   require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

   $name = null;
   $values = null;
   $options = null;
   $selected = array();
   $output = null;
   $first_opt = null;

   $extra = '';

   foreach($params as $_key => $_val) {
      switch($_key) {
      case 'name':
     $$_key = (string)$_val;
     break;

      case 'options':
     $$_key = (array)$_val;
     break;

      case 'selected':
      case 'values':
      case 'outputs':
      case 'output':
      case 'first_opt':
     $$_key = array_values((array)$_val);
     break;

      default:
     $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
     break;
      }
   }

   if (!isset($options) && !isset($values))
      return ''; /* raise error here? */

   $_html_result = '';

   if (is_array($first_opt)){
       foreach ($first_opt as $_key=>$_val)
     $_html_result .= smarty_function_html_options_optoutput_adv($_key, $_val, $selected);
   }

   if (is_array($options)) {

      foreach ($options as $_key=>$_val)
     $_html_result .= smarty_function_html_options_optoutput_adv($_key, $_val, $selected);

   } else {

      foreach ((array)$values as $_i=>$_key) {
     $_val = isset($output[$_i]) ? $output[$_i] : '';
     $_html_result .= smarty_function_html_options_optoutput_adv($_key, $_val, $selected);
      }

   }

   if(!empty($name)) {
      $_html_result = '<select name="' . $name . '"' . $extra . '>' . "\n" . $_html_result . '</select>' . "\n";
   }

   return $_html_result;

}

function smarty_function_html_options_optoutput_adv($key, $value, $selected) {
   if(!is_array($value)) {
      $_html_result = '<option label="' . smarty_function_escape_special_chars($value) . '" value="' .
     smarty_function_escape_special_chars($key) . '"';
      if (in_array($key, $selected))
     $_html_result .= ' selected="selected"';
      $_html_result .= '>' . smarty_function_escape_special_chars($value) . '</option>' . "\n";
   } else {
      $_html_result = smarty_function_html_options_optgroup_adv($key, $value, $selected);
   }
   return $_html_result;
}

function smarty_function_html_options_optgroup_adv($key, $values, $selected) {
   $optgroup_html = '<optgroup label="' . smarty_function_escape_special_chars($key) . '">' . "\n";
   foreach ($values as $key => $value) {
      $optgroup_html .= smarty_function_html_options_optoutput_adv($key, $value, $selected);
   }
   $optgroup_html .= "</optgroup>\n";
   return $optgroup_html;
}

/* vim: set expandtab: */

?>
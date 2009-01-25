SetFont('Times');~~;
MultiCell(0,5,"
Project Name : {$project.name} .
Project URL :
{$config.url}/module.php?act=load&modload=projects&file=projects&action=info&id={$project.id} .
Gantt Chart : ");~~;
Image('{$config.dir}/cache/gantt.jpg',5,50,200);~~;
Ln(5);~~;

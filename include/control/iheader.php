<?
interface Control_IHeader
{
	public function GetColumnSortable($index);
	
	public function GetSortable();

	public function GetSortColumn();

	public function GetSortOrder();

	public function SetColumnSortable($index, $sortable);

	public function SetSort($index, $order);
	
	public function SetSortable($sortable);
}
?>
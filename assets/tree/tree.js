//This function retrieves the children of clicked node
function OpenNode($currentNodeSpan, $tree_name)
{
	if(!$currentNodeSpan.parent().find("ul").length){
		/* ShowLoader(); */
		//children elements don't exists, we need to get them from ajax
		//$new_parent_id = $currentNodeSpan.parent().find("a").data("id");
		$new_parent_id = $currentNodeSpan.data("id");

		//get all_selectable option
		$all_selectable = $(".tree > UL").data("all_selectable");

		$tree_type = $(".tree").data("treetype");

		//first append wrapping UL
		$currentNodeSpan.parent().append("<ul></ul>");
		//then bring node LI from ajax
		$currentNodeSpan.parent().find("ul").load("/Tree/AjaxLoadTreeNode/"+$tree_type+"/"+$new_parent_id+'/'+$all_selectable,
											function(data){
												//after getting chlidren, expand the tree node
												ExpandTreeNode($currentNodeSpan);
												/* HideLoader(); */
											}
										);
	}else{
		//alert("have data");
		//Children elements exist, only expand tree node
		ExpandTreeNode($currentNodeSpan);
	}
}


//This function toggles show/hide of clicked node
function ExpandTreeNode($currentNodeSpan)
{
	var children = $currentNodeSpan.parent('li').find(' > ul > li');
	if (children.is(":visible")) {
	    children.hide('fast');
	    $currentNodeSpan.find(' > i').addClass('fa-plus-square').removeClass('fa-minus-square');
	} else {
	    children.show('fast');
	    $currentNodeSpan.find(' > i').addClass('fa-minus-square').removeClass('fa-plus-square');
	}
	//e.stopPropagation();
}


//This function selects a node and closes the modal
function SelectNode($node_id, $id_field, $node_text, $text_field, $modal_id)
{
	console.log("$id_field: "+$id_field);
	if($id_field!="#"){

		$($id_field).val($node_id);
		$($id_field).trigger('change');
	}
	$($text_field).val($node_text)

	$('#'+$modal_id).modal('hide');
}

<?php

class Pagination {

	public function __construct() {
		
	}

	/**
	 * Calculates the limit, current, previous, next, last, pages values based
	 * on the total rows, rows per page, and page number provided.
	 * 
	 * @param Int $total_rows Total rows of all data for paging.
	 * @param Int $rows_per_page Rows per page.
	 * @param Int $page_num Current page number.
	 * @return Array An array containing limit, current, previous, next, last, info and pages.
	 */
	public function calculatePages($total_rows, $rows_per_page, $page_num) {
		$arr = array();
		// calculate last page
		$last_page = ceil($total_rows / $rows_per_page);
		// make sure we are within limits
		$page_num = (int) $page_num;
		if ($page_num < 1) {
			$page_num = 1;
		} elseif ($page_num > $last_page) {
			$page_num = $last_page;
		}
		$upto = ($page_num - 1) * $rows_per_page;
		//$arr['limit'] = 'LIMIT ' . $upto . ',' . $rows_per_page;
		if ($upto < 0) {
			$upto = 0;
		}
		$arr['limit'] = array($upto, $rows_per_page);
		$arr['current'] = $page_num;
		if ($page_num == 1)
			$arr['previous'] = $page_num;
		else
			$arr['previous'] = $page_num - 1;
		if ($page_num == $last_page)
			$arr['next'] = $last_page;
		else
			$arr['next'] = $page_num + 1;
		$arr['last'] = $last_page;
		$arr['info'] = 'Page (' . $page_num . ' of ' . $last_page . ')';
		$arr['pages'] = $this->getSurroundingPages($page_num, $last_page, $arr['next']);
		return $arr;
	}

	public function getSurroundingPages($page_num, $last_page, $next) {
		$arr = array();
		$show = 5; // how many boxes
		// at first
		if ($page_num == 1) {
			// case of 1 page only
			if ($next == $page_num)
				return array(1);
			for ($i = 0; $i < $show; $i++) {
				if ($i == $last_page)
					break;
				array_push($arr, $i + 1);
			}
			return $arr;
		}
		// at last
		if ($page_num == $last_page) {
			$start = $last_page - $show;
			if ($start < 1)
				$start = 0;
			for ($i = $start; $i < $last_page; $i++) {
				array_push($arr, $i + 1);
			}
			return $arr;
		}
		// at middle
		$start = $page_num - $show;
		if ($start < 1)
			$start = 0;
		for ($i = $start; $i < $page_num; $i++) {
			array_push($arr, $i + 1);
		}
		for ($i = ($page_num + 1); $i < ($page_num + $show); $i++) {
			if ($i == ($last_page + 1))
				break;
			array_push($arr, $i);
		}
		return $arr;
	}

}
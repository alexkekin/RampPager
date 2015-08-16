<?php

class RampPager extends CLinkPager {

	const CSS_DUMMY_PAGE = 'dummy';
	public $rampSize = 5;

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons() {

	        if(($pageCount=$this->getPageCount())<=1) {

	            return array();

	        } else {

		        $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		        $buttons=array();

		        // prev page
		        if(($page=$currentPage-1)<0) $page = 0;
		        $buttons[]=$this->createPageButton($this->prevPageLabel,$page,self::CSS_PREVIOUS_PAGE,$currentPage<=0,false);

		        // internal pages
		        for($i = 0; $i<$pageCount; ++$i) {

					if($i == 0) {

						$buttons[] = $this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

						if($currentPage > ($this->rampSize + 1)) {

							$buttons[] = $this->createDummyButton(self::CSS_DUMMY_PAGE);
						}

					} else {

						if($i == $pageCount-1) {

							if($currentPage < ($pageCount - $this->rampSize)) {

								$buttons[] = $this->createDummyButton(self::CSS_DUMMY_PAGE);
							}
							$buttons[] = $this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);

						} else {

							if($i >= ($currentPage - $this->rampSize) && $i <= ($currentPage + $this->rampSize)) {

								$buttons[] = $this->createPageButton($i+1,$i,self::CSS_INTERNAL_PAGE,false,$i==$currentPage);
							}
						}
					}
		        }

		        // next page
		        if(($page=$currentPage+1)>=$pageCount-1) $page = $pageCount-1;
		        $buttons[]=$this->createPageButton($this->nextPageLabel,$page,self::CSS_NEXT_PAGE,$currentPage>=$pageCount-1,false);
	        }

	        return $buttons;
	}

	protected function createDummyButton($class = null) {

		if(is_null($class)) {

			return '<li>&hellip;</li>';
		} else {

			return '<li class="'.$class.'">&hellip;</li>';
		}
	}
}


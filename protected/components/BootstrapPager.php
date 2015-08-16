<?php

class BootstrapPager extends CLinkPager
{

    const CSS_DUMMY_PAGE = 'disabled hellip';
    const CSS_FIRST_PAGE='hidden';
    const CSS_LAST_PAGE='hidden';
    const CSS_PREVIOUS_PAGE='';
    const CSS_NEXT_PAGE='';
    const CSS_INTERNAL_PAGE='';
    const CSS_HIDDEN_PAGE='disabled';
    const CSS_SELECTED_PAGE='active';

    public function init()
    {
        if($this->nextPageLabel===null)
            $this->nextPageLabel='&raquo;';
        if($this->prevPageLabel===null)
            $this->prevPageLabel='&laquo;';

        if(!isset($this->htmlOptions['class']))
            $this->htmlOptions['class']='';
    }





    public $rampSize = 5;

    /**
     * Creates the page buttons.
     * @return array a list of page buttons (in HTML code).
     */
    protected function createPageButtons()
    {

        if (($pageCount = $this->getPageCount()) <= 1) {

            return array();
        } else {

            $currentPage = $this->getCurrentPage(FALSE); // currentPage is calculated in getPageRange()
            $buttons = array();

            // prev page
            if (($page = $currentPage - 1) < 0)
                $page = 0;
            $buttons[] = $this->createPageButton($this->prevPageLabel, $page, self::CSS_PREVIOUS_PAGE, $currentPage <= 0, FALSE);

            // internal pages
            for ($i = 0; $i < $pageCount; ++$i) {

                if ($i == 0) {

                    $buttons[] = $this->createPageButton($i + 1, $i, self::CSS_INTERNAL_PAGE, FALSE, $i == $currentPage);

                    if ($currentPage > ($this->rampSize + 1)) {

                        $buttons[] = $this->createDummyButton(self::CSS_DUMMY_PAGE);
                    }
                } else {

                    if ($i == $pageCount - 1) {

                        if ($currentPage < ($pageCount - $this->rampSize)) {

                            $buttons[] = $this->createDummyButton(self::CSS_DUMMY_PAGE);
                        }
                        $buttons[] = $this->createPageButton($i + 1, $i, self::CSS_INTERNAL_PAGE, FALSE, $i == $currentPage);
                    } else {

                        if ($i >= ($currentPage - $this->rampSize) && $i <= ($currentPage + $this->rampSize)) {

                            $buttons[] = $this->createPageButton($i + 1, $i, self::CSS_INTERNAL_PAGE, FALSE, $i == $currentPage);
                        }
                    }
                }
            }

            // next page
            if (($page = $currentPage + 1) >= $pageCount - 1)
                $page = $pageCount - 1;
            $buttons[] = $this->createPageButton($this->nextPageLabel, $page, self::CSS_NEXT_PAGE, $currentPage >= $pageCount - 1, FALSE);
        }

        return $buttons;
    }

    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
        if($hidden || $selected)
            $class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        if($hidden) {
            return '<li class="'.$class.'">'.CHtml::link($label,'js:return false;').'</li>';
        } else {
            return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
        }
    }

    protected function createDummyButton($class = NULL)
    {

        if (is_null($class)) {

            return '<li><a href="js:return false;">&hellip;</a></li>';
        } else {

            return '<li class="' . $class . '"><a href="js:return false;">&hellip;</a></li>';
        }
    }

}


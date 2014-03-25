<?php

/**
 * Extension that can be added to controllers to provide Content Controller
 * methods (such as SiteConfig and Menu).
 *
 */
class Middleman_Controller extends Extension {

    private static $allowed_actions = array(
        "SearchForm",
        'results',
    );

    /**
     * Returns the associated database record
     */
    public function data() {
        if(!property_exists($this->owner, "dataRecord"))
            $this->owner->dataRecord = null;

        return $this->owner->dataRecord;
    }

    public function getDataRecord() {
        return $this->owner->data();
    }

    public function setDataRecord($dataRecord) {
        $this->owner->dataRecord = $dataRecord;
        return $this->owner;
    }

    /**
     * Returns a fixed navigation menu of the given level.
     * @return SS_List
     */
    public function getMenu($level = 1) {
        if(ClassInfo::exists("SiteTree")) {
            if($level == 1) {
                $result = SiteTree::get()->filter(array(
                    "ShowInMenus" => 1,
                    "ParentID" => 0
                ));

            } else {
                $parent = $this->owner->data();
                $stack = array($parent);

                if($parent) {
                    while($parent = $parent->Parent) {
                        array_unshift($stack, $parent);
                    }
                }

                if(isset($stack[$level-2]) && !$stack[$level-2] instanceOf Product)
                    $result = $stack[$level-2]->Children();
            }

            $visible = array();

            // Remove all entries the can not be viewed by the current user
            // We might need to create a show in menu permission
            if(isset($result)) {
                foreach($result as $page) {
                    if($page->canView()) {
                        $visible[] = $page;
                    }
                }
            }

            return new ArrayList($visible);
        } else
            return new ArrayList();
    }

    public function Menu($level) {
        return $this->getMenu($level);
    }

    public function SiteConfig() {
        if(ClassInfo::exists("SiteConfig")) {
            if(method_exists($this->owner->dataRecord, 'getSiteConfig')) {
                return $this->owner->dataRecord->getSiteConfig();
            } else {
                return SiteConfig::current_site_config();
            }
        }
    }

    /**
     * Site search form
     */
    public function SearchForm() {
        if(FulltextSearchable::get_searchable_classes() && class_exists("SearchForm")) {
            $searchText =  _t('SearchForm.SEARCH', 'Search');

            if($this->owner->request && $this->owner->request->getVar('Search')) {
                $searchText = $this->owner->request->getVar('Search');
            }

            $fields = new FieldList(
                new TextField('Search', false, $searchText)
            );
            $actions = new FieldList(
                new FormAction('results', _t('SearchForm.GO', 'Go'))
            );

            $form = new SearchForm($this->owner, 'SearchForm', $fields, $actions);
            $form->classesToSearch(FulltextSearchable::get_searchable_classes());

            return $form;
        }
    }

}

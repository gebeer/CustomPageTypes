<?php

namespace ProcessWire;

class MyUsers extends PagesType
{

    /**
     * Construct the MyUsers manager for the given parent and template
     *
     * @param Template|int|string|array $templates Template object or array of template objects, names or IDs
     * @param int|Page|array $parents Parent ID or array of parent IDs (may also be Page or array of Page objects)
     */
    public function __construct($templates = array(), $parents = array())
    {
        parent::__construct(wire(), $templates, $parents);

        // Make sure we always include the single_user template and /users/ parent page
        $this->addTemplates("single_user");
        $this->addParents($this->pages->get("template=single_users")->id);
        $this->setPageClass('MyUser');
    }

    /**
     * Custom method to find by date range
     *
     * @param int $start timestamp
     * @param int $end timestamp
     * @param string|null $additionalSelector (optional)
     * @return PageArray
     */
    // public function findInDateRange($start, $end, $additionalSelector = null){
    //     // Build selector
    //     $selector = "enddate>=$start, (enddate<=$end), (startdate<=$end)";
    //     if($additionalSelector) $selector .= ", " . $additionalSelector;

    //     // Search only the available events with the selector
    //     return $this->find($selector);
    // }
}

class MyUser extends Page
{

    /**
     * @var Page
     * orga-unit page of company that user belongs to
     */
    public $company;


    /**
     * Create a new MyUser page in memory.
     *
     * @param Template $tpl Template object this page should use.
     */
    public function __construct(Template $tpl = null)
    {
        if (is_null($tpl)) $tpl = $this->templates->get('single_user');
        if (!$this->parent_id) $this->set('parent_id', $this->pages->get("template=single_users")->id);
        parent::__construct($tpl);
    }

    /**
     * assign custom properties here
     * after page is loaded $this = $page
     */
    public function ___loaded()
    {
        $this->company = ($this->orga_unit) ? $this->orga_unit->orga_parent : null;
        $this->set('company', $this->company);
    }


    /**
     * assign custom methods below here
     */


    /**
     * return all team members for this user
     *
     * @return PageArray
     */
    public function getTeamMembers()
    {
        $teamId = $this->orga_unit->id;
        if ($this->orga_unit) return $this->wire()->pages->find("template=single_user, orga_unit={$teamId}, parent!=/trash/");
        return new PageArray();
    }
}

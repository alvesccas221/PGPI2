<?php
namespace ycd;

class CountdownType
{
    private $available = false;
    private $isComingSoon = false;
    private $name = '';
    private $group = array();
    private $accessLevel = YCD_FREE_VERSION;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setGroup($group)
    {
        $this->group = $group;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setAvailable($available)
    {
        $this->available = $available;
    }

    public function isAvailable()
    {
        return $this->available;
    }

    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;
    }

    public function getAccessLevel()
    {
        return $this->accessLevel;
    }
    
    public function setIsComingSoon($isComingSoon)
    {
        $this->isComingSoon = $isComingSoon;
    }

    public function getIsComingSoon()
    {
        return $this->isComingSoon;
    }

    public function isVisible()
    {
    	$status = true;
	    $isAvailable = $this->isAvailable();

		if (!$isAvailable && YCD_PKG_VERSION != YCD_FREE_VERSION) {
			$status = false;
		}

	    if (!empty($_GET['ycd_group_name']) && $_GET['ycd_group_name'] != 'all') {
		    $group = $this->getGroup();
		    $status = $status && in_array($_GET['ycd_group_name'], $group);
	    }

	    return $status;
    }
}
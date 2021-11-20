<?php

namespace ycd;

class TypesNavBar
{
	public static function render()
	{
		ob_start();
		?>
		<div id="crontrol-header-ycd-groups">
			<ul class="nav nav-tab-wrapper">
				<?php echo self::renderOptions()?>
			</ul>
		</div>
		<?php
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	private static function renderOptions()
	{
		global $YCD_TYPES;
		$groups = $YCD_TYPES['typesGroupList'];
		$activeGroupName = self::getActiveGroupName();
		$url = admin_url('edit.php?post_type='.YCD_COUNTDOWN_POST_TYPE.'&page='.YCD_COUNTDOWN_POST_TYPE);
		$urls = '';
		foreach ($groups as $groupKey => $groupTitle) {
			$activeClass = '';

			if ($activeGroupName == $groupKey) {
				$activeClass = 'nav-tab-active';
			}
			$urls .= '<a href="'.$url.'&ycd_group_name='.$groupKey.'" class="nav-tab '.$activeClass.'">'.$groupTitle.'</a>';
		}

		return $urls;
	}

	private static function getActiveGroupName()
	{
		$groupName = 'all';
		if (!empty($_GET['ycd_group_name'])) {
			$groupName = $_GET['ycd_group_name'];
		}

		return $groupName;
	}
}
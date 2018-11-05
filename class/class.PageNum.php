<?php
/**
 * Get Page Number
 * @uses SESSION variables
 */
class PageNum
{
	// Set Value
	private $this_posttype_order    = 0;
	private $use_contact_flg        = 0;
	private $use_multisite_flg      = 0;
	private $use_posttype_flg       = 0;
	private $use_language_flg       = 0;
	private $use_customitem_flg     = 0;
	private $use_group_flg          = 0;
	private $user_role              = 0;
	private $comment_type           = null;
	private $count_post             = 0;
	private $count_contact          = 0;
	private $editable_role_category_post    = 0;
	private $editable_role_tag_post         = 0;
	private $editable_role_category_contact = 0;

	// Return Values
	private $page_main       = 0;
	private $page_sub_post   = 0;
	private $page_sub_user   = 0;
	private $page_sub_option = 0;

	function __construct()
	{
		global $session_key;
		if (isset($_SESSION[$session_key]['common']['this_posttype_order']))     $this -> this_posttype_order    = $_SESSION[$session_key]['common']['this_posttype_order'];
		if (isset($_SESSION[$session_key]['common']['use_contact_flg']))         $this -> use_contact_flg        = $_SESSION[$session_key]['common']['use_contact_flg'];
		if (isset($_SESSION[$session_key]['configs']['use_multisite_flg']))      $this -> use_multisite_flg      = $_SESSION[$session_key]['configs']['use_multisite_flg'];
		if (isset($_SESSION[$session_key]['configs']['use_posttype_flg']))       $this -> use_posttype_flg       = $_SESSION[$session_key]['configs']['use_posttype_flg'];
		if (isset($_SESSION[$session_key]['configs']['use_multilingual_flg']))   $this -> use_language_flg       = $_SESSION[$session_key]['configs']['use_multilingual_flg'];
		if (isset($_SESSION[$session_key]['configs']['use_group_flg']))          $this -> use_group_flg          = $_SESSION[$session_key]['configs']['use_group_flg'];
		if (isset($_SESSION[$session_key]['user']['role']))                      $this -> user_role              = $_SESSION[$session_key]['user']['role'];
		if (isset($_SESSION[$session_key]['configs']['editable_role_category_post']))    $this -> editable_role_category_post     = $_SESSION[$session_key]['configs']['editable_role_category_post'];
		if (isset($_SESSION[$session_key]['configs']['editable_role_tag_post']))         $this -> editable_role_tag_post          = $_SESSION[$session_key]['configs']['editable_role_tag_post'];
		if (isset($_SESSION[$session_key]['configs']['editable_role_category_contact'])) $this -> editable_role_category_contact  = $_SESSION[$session_key]['configs']['editable_role_category_contact'];

		if (isset($_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['use_customitem_flg']))
		{
			$this -> use_customitem_flg = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['use_customitem_flg'];
		}
		if (isset($_SESSION[$session_key]['common']['posttypes_extra'][$_SESSION[$session_key]['common']['this_posttype']]['use_customitem_flg']))
		{
			$this -> use_customitem_flg = $_SESSION[$session_key]['common']['posttypes_extra'][$_SESSION[$session_key]['common']['this_posttype']]['use_customitem_flg'];
		}

		if (isset($_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['comment_type']))
		{
			$this -> comment_type = $_SESSION[$session_key]['common']['posttypes'][$_SESSION[$session_key]['common']['this_posttype']]['comment_type'];
		}

		if (! empty($_SESSION[$session_key]['common']['this_site']))
		{
			$this -> count_post += count($_SESSION[$session_key]['common']['posttypes']);
			$this -> page_main  += count($_SESSION[$session_key]['common']['posttypes']);
			if ($this -> use_contact_flg && ! empty($_SESSION[$session_key]['common']['posttypes_extra']))
			{
				$this -> count_contact += count($_SESSION[$session_key]['common']['posttypes_extra']);
				$this -> page_main     += count($_SESSION[$session_key]['common']['posttypes_extra']);
			}
		}
		else {
			$this -> page_main --;
		}
	}

	function getMain($page_name)
	{
		/* main page default order
		   -----------------------
		   1: post (default number, increase by amount of custom posttype)
		   2: contact (posts + 1)
		   3: media   (posts + 2)
		   4: user    (posts + 3)
		   5: option  (posts + 4)
		   6: config  (posts + 5)
		   ----------------------- */
		if ($page_name == 'post' || $page_name == 'contact' || $page_name == 'media' || $page_name == 'user' || $page_name == 'option' || $page_name == 'config')
		{
			if ($page_name == 'post'){
				$this -> page_main = $this -> this_posttype_order;
			}
			if ($page_name == 'contact'){
				$this -> page_main = $this -> count_post + $this -> this_posttype_order;
			}
			if ($page_name == 'media'){
				$this -> page_main += 1;
			}
			if ($page_name == 'user'){
				$this -> page_main += 2;
			}
			if ($page_name == 'option'){
				$this -> page_main += 3;
			}
			if ($page_name == 'config')
			{
				if ($this -> use_multisite_flg || $this -> use_posttype_flg || $this -> use_language_flg)
				{
					if ($this -> user_role <= 2)
					{
						$this -> page_main += 4;
					}
					else {
						$this -> page_main += 3;
					}
				}
				else {
					$this -> page_main += 3;
				}
			}
		}
		return $this -> page_main;
	}

	function getSubPost($page_name, $comment_type = 0)
	{
		/* sub [post] page default order
		 -----------------------
		1: posts
		2: post
		3: category
		4: tag
		5: custom_item
		6: comment
		7: posttype_config
		----------------------- */
		if ($page_name == 'posts' || $page_name == 'post' || $page_name == 'category' || $page_name == 'tag' || $page_name == 'custom_item' || $page_name == 'comment' || $page_name == 'config_posttype')
		{
			if ($page_name == 'posts'){
				$this -> page_sub_post = 1;
			}
			if ($page_name == 'post'){
				$this -> page_sub_post = 2;
			}
			if ($page_name == 'category'){
				$this -> page_sub_post = 3;
			}
			if ($page_name == 'tag')
			{
				$this -> page_sub_post = 4;

				// Adjust position
				if ($this -> user_role > $this -> editable_role_category_post) $this -> page_sub_post -= 1;
			}
			if ($page_name == 'custom_item')
			{
				$this -> page_sub_post = 5;

				// Adjust position
				if ($this -> user_role > $this -> editable_role_category_post) $this -> page_sub_post -= 1;
				if ($this -> user_role > $this -> editable_role_tag_post)      $this -> page_sub_post -= 1;
			}
			if ($page_name == 'config_posttype')
			{
				$this -> page_sub_post = 6;

				// Adjust position
				if ($this -> user_role > 2 || ($this -> user_role <= 2 && ! $this -> use_customitem_flg)) $this -> page_sub_post -= 1; // custom_item
				if ($this -> user_role > $this -> editable_role_category_post) $this -> page_sub_post -= 1; // category
				if ($this -> user_role > $this -> editable_role_tag_post)      $this -> page_sub_post -= 1; // tag
			}
			if ($page_name == 'comment')
			{
				$this -> page_sub_post = (array_search($comment_type, explode(',', $this -> comment_type)) + 1) + 6;

				// Adjust position
				if ($this -> user_role > 2 || ($this -> user_role <= 2 && ! $this -> use_customitem_flg)) $this -> page_sub_post -= 1; // custom_item
				if ($this -> user_role > $this -> editable_role_category_post)   $this -> page_sub_post -= 1; // category
				if ($this -> user_role > $this -> editable_role_tag_post)        $this -> page_sub_post -= 1; // tag
				if ($this -> user_role > 2) $this -> page_sub_post -= 1; // config_posttype
			}
		}
		return $this -> page_sub_post;
	}

	function getSubContact($page_name)
	{
		/* sub [contact] page default order
		 -----------------------
		1: contacts
		2: contact
		3: category
		4: custom_item
		5: config_contact
		----------------------- */
		if ($page_name == 'contacts' || $page_name == 'contact' || $page_name == 'category' || $page_name == 'config_contact')
		{
			if ($page_name == 'contacts')
			{
				$this -> page_sub_post = 1;
			}
			if ($page_name == 'contact')
			{
				$this -> page_sub_post = 2;
			}
			if ($page_name == 'category')
			{
				$this -> page_sub_post = 3;
			}
			if ($page_name == 'custom_item')
			{
				$this -> page_sub_post = 4;

				// Adjust position
				if ($this -> user_role > $this -> editable_role_category_contact) $this -> page_sub_post -= 1;
			}
			if ($page_name == 'config_contact')
			{
				$this -> page_sub_post = 5;

				// Adjust position
				if ($this -> user_role > 2 || ($this -> user_role <= 2 && ! $this -> use_customitem_flg)) $this -> page_sub_post -= 1; // custom_item
				if ($this -> user_role > $this -> editable_role_category_contact) $this -> page_sub_post -= 1;
			}
		}
		return $this -> page_sub_post;
	}


	function getSubUser($page_name)
	{
		/* sub [user] page default order
		 -----------------------
		1: edit
		2: group
		3: password
		----------------------- */
		if ($page_name == 'edit' || $page_name == 'password' || $page_name == 'group')
		{
			if ($page_name == 'edit'){
				$this -> page_sub_user = 1;
			}
			if ($page_name == 'group')
			{
				if ($this -> user_role <= 7)
				{
					$this -> page_sub_user = 2;
				}
				else {
					$this -> page_sub_user = 1;
				}
			}
			if ($page_name == 'password')
			{
				if ($this -> user_role <= 7)
				{
					if ($this -> use_group_flg)
					{
						$this -> page_sub_user = 3;
					}
					else {
						$this -> page_sub_user = 2;
					}
				}
				else {
					$this -> page_sub_user = 1;
				}
			}
		}
		return $this -> page_sub_user;
	}

	function getSubOption($page_name)
	{
		/* sub [option] page default order
		 -----------------------
		1: site
		2: posttype
		3: language
		----------------------- */
		if ($page_name == 'site' || $page_name == 'posttype' || $page_name == 'language')
		{
			if ($page_name == 'site'){
				$this -> page_sub_option = 1;
			}
			if ($page_name == 'posttype')
			{
				if ($this -> use_multisite_flg) {
					$this -> page_sub_option = 2;
				}
				else {
					$this -> page_sub_option = 1;
				}
			}
			if ($page_name == 'language')
			{
				if ($this -> use_multisite_flg && $this -> use_posttype_flg) {
					$this -> page_sub_option = 3;
				}
				elseif ($this -> use_multisite_flg || $this -> use_posttype_flg) {
					$this -> page_sub_option = 2;
				}
				else {
					$this -> page_sub_option = 1;
				}
			}
		}
		return $this -> page_sub_option;
	}

}
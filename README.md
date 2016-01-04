# Trial Manager

## Setting Up

* Configure Global Variables
 * The path to the right of 'php_value auto_prepend_file' is for the config.php file. Make sure it's valid for your server.
 * In js/global_var.js, make sure gVar.root is set to the root directory of this site RELATIVE to the root directory of your web server. By default, this variable is set to the trial-mgr directory in the server's root directory.
 
* Set Up The Database
 * Create the database using setting_up/db_struct.sql. This only contains the structure of the database.
 * Populate the param_input and param_dropdown_options tables using their respective '_data.sql' files in the setting up directory.



## End User Info

	* FAQ
		* **If a trial is deleted, will it disappear from its parent groups?** No: it will still appear on the group page (will be labeled as deleted) and will remain in the trial_group_child table (deleted_flag = 1).



## Developer Info

### Database

* Tables
	* trial - Information about trials. 1 row per trial.
		* Fields
			* trial_seq - Surrogate primary key. Auto-increments.
			* insert_dt - Date that the trial was created in the database. User doesn't have direct control over this.
			* update_dt - Date that the trial was updated in the database. Null if trial has been created by never updated. User doesn't have direct control over this.
	* trial_comment - Comments on each trial. Can have multiple rows per trial.
	* trial_ht - Heats on each trial. Can have multiple rows per trial.
		* Fields
			* ht_seq - Used to maintain the order in which the user enters heats. In other words, it makes sure the 1st heat the user enters is the 1st displayed.
			* comment - Not currently used.
	* trial_group - Information about groups. 1 row per group.
		* Fields
			* group_seq - Surrogate primary key. Auto-increments.
			* insert_dt - Date that the group was created in the database. User doesn't have direct control over this.
			* update_dt - Date that the group was updated in the database. Null if group has been created by never updated. User doesn't have direct control over this.
	* trial_group_comment - Comments on each group. Can have multiple rows per group.
	* trial_group_child - Trials on each group. Can have multiple rows per group.
		* Fields
			* deleted_flag - Will be '1' when a trial was deleted but hasn't been removed as a child of a group.
			* comment - Not currently used.
	* param_input - Used to generate HTML inputs, textareas, selects, etc. Improves maintainability since input modifications can be made without digging into the HTML.
		* Fields
			* name_id - Links hardcoded PHP with this table. DO NOT CHANGE ANY VALUES IN THIS FIELD.
			* html_type - Determines which type of input to create (e.g. input, textarea, select, etc.). DO NOT CHANGE ANY VALUES IN THIS FIELD.
			* title - Text displayed above the input.
			* title_short - Text displayed above the input when resolution is very narrow (e.g. mobile phones). Disable by setting to NULL.
			* tooltip_info - Tooltip text that is displayed when user hovers over the input. Only applies to the info module. Disable by setting to NULL.
			* tooltip_search - Tooltip text that is displayed when user hovers over the input. Only applies to the search module. Disable by setting to NULL.
	* param_dropdown_options - Used to generate options for HTML selects. Improves maintainability since option modifications can be made without digging into the HTML.
		* Fields
			* name_id - Links this table to param_input and hardcoded PHP. DO NOT CHANGE ANY VALUES IN THIS FIELD.
			* order_num - Used to order options in the dropdown.
			* option_value - Not currently used.
			* option_text - The text that will be display for the option.

### Pages

* better-browser
* create
* lookup
* recent
* search
* update
* view

### Modules

* child_list
* comment_add
* comment_list
* heat_data
* html_foot
* html_head
* info
* list_ongoing
* list_recent
* list_upcoming
* lookup
* nav_bar
* search
* search_trial_add
* toggle_pagetype

### How To

* 

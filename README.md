# Trial Manager

## Setting Up

* Configure Global Variables
 * The path to the right of 'php_value auto_prepend_file' is for the config.php file. Make sure it's valid for your server.
 * In js/global_var.js, make sure gVar.root is set to the root directory of this site RELATIVE to the root directory of your web server. By default, this variable is set to the trial-mgr directory in the server's root directory.
 
* Set Up The Database
 * Create the database using setting_up/db_struct.sql. This only contains the structure of the database.
 * Populate the param_input and param_dropdown_options tables using their respective '_data.sql' files in the setting up directory.


## Database Info

* Tables
 * trial - Information about trials. 1 row per trial.
 * trial_comment - Comments on each trial. Can have multiple rows per trial.
 * trial_ht - Heats on each trial. Can have multiple rows per trial.
 * trial_group - Information about groups. 1 row per group.
 * trial_group_comment - Comments on each group. Can have multiple rows per group.
 * trial_group_child - Trials on each group. Can have multiple rows per group.
 * param_input - Used to generate HTML inputs, textareas, selects, etc. Improves maintainability since input modifications can be made without digging into the HTML.
 * param_dropdown_options - Used to generate options for HTML selects. Improves maintainability since option modifications can be made without digging into the HTML.
   * Deleting/changing an option does not affect trials/groups that use that option. For example, all trials with "Cost" as their goal_type will remain unchanged if you delete "Cost" from param_dropdown_options.


## Page Info
* better-browser
* create
* lookup
* recent
* search
* update
* view


## Module Info

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

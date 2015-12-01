GRANT SELECT ON trial_mgr.* TO 'trial_mgr_ro'@'localhost' IDENTIFIED BY 'manofsteel';
GRANT SELECT, INSERT, UPDATE, DELETE ON trial_mgr.* TO 'trial_mgr_wr'@'localhost' IDENTIFIED BY 'womanofsteel';
FLUSH PRIVILEGES;
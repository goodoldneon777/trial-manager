delete from trial_mgr.trial_ht where trial_seq in (select trial_seq from trial_mgr.trial where name like '%foo%');
delete from trial_mgr.trial_comment where trial_seq in (select trial_seq from trial_mgr.trial where name like '%foo%');
delete from trial_mgr.trial where name like '%foo%';


delete from trial_mgr.trial_group_child where group_seq in (select group_seq from trial_mgr.trial_group where name like '%foo%');
delete from trial_mgr.trial_group_comment where group_seq in (select group_seq from trial_mgr.trial_group where name like '%foo%');
delete from trial_mgr.trial_group where name like '%foo%';
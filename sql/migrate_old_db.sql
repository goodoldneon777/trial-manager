delete from trial_mgr_alpha.trial;
delete from trial_mgr_alpha.trial_ht;
delete from trial_mgr_alpha.trial_comment;


insert into trial_mgr_alpha.trial
(trial_seq, name, start_dt, end_dt, owner, proc_chg_num, twi_num, unit, goal_type, change_type, bop_vsl, degas_vsl, argon_station, caster_num, strand_num, comment_goal, comment_monitor, comment_general, comment_conclusion, create_dt, update_dt)
select * from trial_mgr.trial;


insert into trial_mgr_alpha.trial_comment
(trial_seq, comment_seq, comment_dt, comment_text)
select trial_seq, comment_seq, comment_dt, comment_text from trial_mgr.trial_comment;


insert into trial_mgr_alpha.trial_ht
(trial_seq, ht_num, tap_yr, ht_seq, trial_name, trial_start_dt, trial_end_dt, bop_vsl, degas_vsl, argon_num, caster_num, strand_num, comment)
select * from trial_mgr.trial_ht;
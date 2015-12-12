delete from trial where trial_name like '%foo%';

delete from trial_ht where trial_seq = (select trial_seq from trial where trial_name like '%foo%');

delete from trial_comment where trial_seq = (select trial_seq from trial where trial_name like '%foo%');

delete from trial_group where name like '%foo%';
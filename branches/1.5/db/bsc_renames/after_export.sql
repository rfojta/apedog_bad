update bsc_strategy set csfs = (select id from csfs where shortcut = csf_name limit 0,1)

update bsc_operation
set `when` = str_to_date(when_txt, '%d.%m.%Y')
WHERE `when_txt` REGEXP '[[:digit:]]{2}\.[[:digit:]]{1,2}\.[[:digit:]]{4}'


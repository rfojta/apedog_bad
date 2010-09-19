update bsc_strategy set csfs = (select id from csfs where shortcut = csf_name limit 0,1)

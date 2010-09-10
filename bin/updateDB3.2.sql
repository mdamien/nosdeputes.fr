
UPDATE intervention SET section_id = 8634 WHERE id IN (395528,395529,395530);
UPDATE intervention SET section_id = 1356 WHERE id IN (49344,49345);
UPDATE intervention SET section_id = 5039 WHERE id IN (243124, 243125, 243126);
UPDATE intervention SET section_id = 621 WHERE id IN (21725,21726);
UPDATE intervention SET section_id = 4185 WHERE id IN (161761,161762,161763);
UPDATE intervention SET section_id = 10334 WHERE id IN (457894,457895,457896);


DELETE s FROM `section` s where id in (3362,7751);

DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 1;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 2;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 180;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 714;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 784;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 785;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 909;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 910;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 951;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 1043;	
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 1213;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 1356;	
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 2101;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 2626;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 2648;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 2765;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 3589;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 3875;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 3895;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 3953;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 5039;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 6731;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 6512;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 6521;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 7181;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 7534;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 9613;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 9710;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 10523;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 11318;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 910 and t.triple_value in (1127,1198);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 5751 and t.triple_value in (2261,2279,2303);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 4450 and t.triple_value in (1360,1365);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 5870 and t.triple_value = 100;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 31 and t.triple_value in (1211, 1157);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 9571 and t.triple_value = 2061;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 9417 and t.triple_value = 2225;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 5773 and t.triple_value = 186;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 10320 and t.triple_value = 2241;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 6056 and t.triple_value = 1331;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 6048 and t.triple_value = 1103;
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 13 and t.triple_value in (284,295,354,355,410,1127,1198);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 11285 and t.triple_value in (2335,2694);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id = 20 and t.triple_value in (189,276,351);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join section s on s.id = ta.taggable_id where taggable_model = "Section" and t.triple_key = "numero" and s.section_id in (10918);
DELETE ta FROM `tagging` ta join tag t on t.id = ta.tag_id join intervention i on i.id = ta.taggable_id where taggable_model = "Intervention" and t.triple_key = "numero" and i.seance_id in (3804, 3822) and t.triple_value in (1451,2622);


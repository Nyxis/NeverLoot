-- Garalon
update wow_objet set id_source_objet = 622 where id_source_objet in (594, 607) and id_slot1 != 9;

-- Garde de pierre
update wow_objet set id_source_objet = 623 where id_objet >= 85922 and id_objet <= 85979 and id_source_objet = 588;
update wow_objet set id_source_objet = 623 where id_objet >= 87012 and id_objet <= 87021 and id_source_objet = 588;
update wow_objet set id_source_objet = 623 where id_objet in (87827, 89766, 89767, 89768, 89818, 89819, 89929, 89930, 89931, 89936) and id_source_objet = 588;

-- Esprits Rois
update wow_objet set id_source_objet = 624 where id_objet >= 86047 and id_objet <= 86129 and id_source_objet = 588;
update wow_objet set id_source_objet = 624 where id_objet >= 87045 and id_objet <= 87056 and id_source_objet = 588;
update wow_objet set id_source_objet = 624 where id_objet in (89935) and id_source_objet = 588;

-- Volonté
update wow_objet set id_source_objet = 629 where id_objet >= 86142 and id_objet <= 86152 and id_source_objet = 588;
update wow_objet set id_source_objet = 629 where id_objet >= 87069 and id_objet <= 87825 and id_source_objet = 588;
update wow_objet set id_source_objet = 629 where id_objet in (89820, 89823, 89825, 89941, 89942) and id_source_objet = 588;

-- Lei Shi
update wow_objet set id_source_objet = 618 where id_source_objet = 600;

-- Protecteurs
update wow_objet set id_source_objet = 620 where id_source_objet = 598;


-- token ??
update wow_objet set id_source_objet = null where id_source_objet = 612 and classes = "";

-- 2,14
update wow_objet set id_source_objet = 620 where json_source like "%\"source\":[2,14]%" and id_source_objet is null;

-- objets existent pas
delete from wow_objet where ilevel in (509, 502) and id_source_objet is null;

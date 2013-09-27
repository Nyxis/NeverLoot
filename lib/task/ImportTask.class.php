<?php

class ImportTask extends sfBaseTask
{
    protected function configure()
    {
        // // add your own arguments here
        // $this->addArguments(array(
        //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
        // ));

        $this->addOptions(array(
            new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
            new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
            new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'propel'),
            // add your own options here
        ));

        $this->namespace        = 'nl';
        $this->name             = 'Import';
        $this->briefDescription = '';
        $this->detailedDescription = '';
    }

    protected function execute($arguments = array(), $options = array())
    {
        $databaseManager = new sfDatabaseManager($this->configuration);
        $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

        // for ($i = 79327; $i < 90000; $i++) {
        // for ($i = 90915; $i < 95000; $i++) {
        // for ($i = 93000; $i < 105000; $i++) {
        //     try {
        //         $objet = new Objet();
        //         $objet->setIdObjet($i);

        //         $objet->import(array('min_ilvl' => 522));
        //         $objet->save();

        //         echo 'item+ >> '.$i.' : '.$objet->getNomFr().' ('.$objet->getIlevel().')'."\n";
        //     } catch (Exception $e) {
        //         echo 'error >> '.$i.' : '.$e->getMessage()."\n";
        //     }
        // }

        $slotmap = array(
            1 => array(1, null), // helm
            2 => array(2, null), // neck
            3 => array(3, null), // shoulders
            5 => array(5, null), // chest
            6 => array(6, null), // belt
            7 => array(7, null), // legs
            8 => array(8, null), // boots
            9 => array(9, null), // bacers
            10 => array(10, null), // gloves
            16 => array(15, null), // back

            11 => array(11, 12), // rings
            12 => array(13, 14), // trinket

            23 => array(17, null), // off hand
            14 => array(17, null), // shields

            17 => array(16, null), // 2M
            13 => array(16, null), // 1M
            15 => array(16, null), // Wands
            21 => array(16, null), // Right Hand
        );

        $tokenmap = array(
            64   => 'Chaman',
            32   => 'Chevalier de la mort',
            1024 => 'Druide',
            8    => 'Voleur',
            4    => 'Chasseur',
            2    => 'Paladin',
            1    => 'Guerrier',
            128  => 'Mage',
            256  => 'Démoniste',
            16   => 'Prêtre',
            512  => 'Moine',

            1192 => 'Voleur//Mage//Chevalier de la mort//Druide',
            581  => 'Chaman//Guerrier//Chasseur//Moine',
            274  => 'Prêtre//Paladin//Démoniste'
        );

        $mapRaids = nlMisc::indexBy('IdZone', RaidQuery::create()->find());
        $metaZones = array(
            5805 => 12
        );

        // SourceObjetQuery::create()->deleteAll();

        $itemList = ObjetQuery::create()
            ->filterByIdObjet(93000, Criteria::GREATER_EQUAL)
            ->find();

        foreach ($itemList as $item) {
            try {
                // $item->setJsonSource('{'.$item->getJsonSource().'}');

                $item->setNomFr('');
                $item->import(array('min_ilvl' => 522));
                $item->save();
                continue;

                $jsonSource = json_decode($item->getJsonSource(), true);
                $item->setHeroique(isset($jsonSource['heroic']));

                // class specific
                $item->setClasses('');
                if (isset($jsonSource['reqclass']) && isset($tokenmap[$jsonSource['reqclass']])) {
                    $item->setClasses($tokenmap[$jsonSource['reqclass']]);
                }

                // slot
                if (isset($slotmap[$jsonSource['slot']])) {
                    list($slot1, $slot2) = $slotmap[$jsonSource['slot']];
                    $item->setIdSlot1($slot1);
                    $item->setIdSlot2($slot2);
                }

                if ($jsonSource['subclass'] <= 4 && $jsonSource['subclass'] >= 1) {
                    $item->setIdArmorType($jsonSource['subclass']);
                }

                $item->save();

                if (isset($sourceObj)) {
                    unset($sourceObj);
                }

                if (!isset($jsonSource['source'])) {

                    // 5.2 : les tokens ne sont pas match dans wowhead
                    // on ajoute une source pour lancer le match du token
                    $jsonSource['source'] = 5;
                }

                if (isset($jsonSource['reqclass'])) {
                    $jsonSource['source'] = 5;
                }

                $source = (array) $jsonSource['source'];
                $source = in_array(5, $source) ? 5 : array_pop($source);

                // -----------------------------------------------------------
                // 5: marchands
                // -----------------------------------------------------------
                if ($source == 5) {

                    // objet vendu en vaillances ou quête par défaut
                    $sourceObj = $this->createSource('Vaillances', null, 'achat');

                    $mapLibToken = array(
                        1 => array('Couronne%', 'Heaume%'),
                        3 => array('Epaulières%', 'Mantelet%'),
                        5 => array('Plastron%'),
                        7 => array('Jambières%'),
                        10 => array('Gantelets%')
                    );

                    // token -> objet à classe définie
                    if (!empty($jsonSource['reqclass']) && !empty($mapLibToken[$jsonSource['slot']])) {

                        // on retrouve le token
                        $token = ObjetQuery::create()
                            ->condition('ilevel', 'Objet.Ilevel = ?', $jsonSource['level'])
                            ->condition('slot', 'Objet.IdSlot1 IS NULL', null)
                            ->condition('classes', 'Objet.Classes LIKE ?', '%'.$item->getClasses().'%')
                            ->combine(array('ilevel', 'slot', 'classes'), 'and', 'base');

                        $cond = array();
                        foreach ($mapLibToken[$jsonSource['slot']] as $key => $namePart) {
                            $condName = $jsonSource['slot'].'_'.$key;
                            $token = $token->condition($condName, 'Objet.NomFr LIKE ?', $namePart);
                            $cond[] = $condName;
                        }

                        $token = $token
                            ->combine($cond, 'or', 'nom')
                            ->where(array('base', 'nom'), 'and')
                            ->findOne();

                        if (!empty($token)) {
                            $sourceObj = $this->createSource('Objet', $token->getIdObjet(), 'token');
                            $sourceObj->setDescription($token->getNomFr().' - '.$token->getClasses());
                        }
                    }
                }

                // -----------------------------------------------------------
                // 2: raids
                // -----------------------------------------------------------
                if ($source == 2) {
                    if (empty($jsonSource['sourcemore'])) {
                        throw new Exception('Pas de sourcemore');
                    }

                    $sourcemore = $jsonSource['sourcemore'][0];
                    if (empty($sourcemore['z'])) {
                        throw new Exception('Pas de zone');
                    }

                    $zone = $sourcemore['z'];
                    if (empty($mapRaids[$zone])) {
                        if (isset($metaZones[$zone])) {
                            $zone = $metaZones[$zone];
                        } else {
                            throw new Exception(sprintf('Raid non supporte : %s', $zone));
                        }
                    }

                    // boss
                    if (!empty($sourcemore['n'])) {

                        $bossName = preg_replace('/\[(.+)\]/', '$1', $sourcemore['n']);

                        // on cherche le boss dans le raid
                        $bossList = $mapRaids[$zone]->getBosss(
                            BossQuery::create()->filterByCadavreEn('%'.$bossName.'%', Criteria::LIKE)
                        );

                        if ($bossList->isEmpty()) {
                            throw new Exception(sprintf('Boss inconnu : %s', $bossName));
                        }

                        $boss = $bossList->getFirst();
                        $sourceObj = $this->createSource('Boss', $boss->getIdBoss(), 'boss');
                        $sourceObj->setDescription($boss->getNomFr());
                    } else {
                        // loot partagé
                        $raid = $mapRaids[$zone];

                        if (!empty($sourcemore['bd']) || !empty($sourcemore['dd'])) {
                            $sourceObj = $this->createSource('Raid', $raid->getIdRaid(), 'zone');
                        }

                        // trash loot
                        if (count($sourcemore) == 1) {
                            $sourceObj = $this->createSource('Raid', $raid->getIdRaid(), 'trashs');
                        }
                        $sourceObj->setDescription($raid->getNomFr());
                    }
                }

                // -----------------------------------------------------------
                // 1,4 : craft et quêtes
                // -----------------------------------------------------------
                if ($source == 1 || $source == 4) {
                    $sourceObj = $this->createSource('Craft', null, 'craft');
                }

                if (!empty($sourceObj)) {
                    $item->setSourceObjet($sourceObj);
                    $item->save();
                }

            } catch (Exception $e) {
                echo sprintf("error >> %s : %s (%s) -> %s\n",
                    $item->getIdObjet(),
                    $item->getNomFr(),
                    $item->getIlevel(),
                    $e->getMessage()
                );

                continue;
            }
        }
    }

    /**
     *
     */
    protected function createSource($type, $idType, $code)
    {
        return SourceObjetQuery::create()
            ->filterByType($type)
            ->filterByIdType($idType)
            ->filterByCode($code)
            ->findOneOrCreate();
    }
}

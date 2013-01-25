<?php echo str_replace("\n", '', sprintf('%s : %s a cloturé la soirée %s.',
    date('d/m'),
    get_partial('log/perso', array('perso' => $sf_user->load()->getMain())),
    get_partial('log/soiree', array('soiree' => $soiree))
));

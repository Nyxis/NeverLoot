<?php echo sprintf('%s : %s a gagné <span class="score">%s soir%s</span> pour le raid %s (%s).',
    date('d/m'),
    get_partial('log/perso', array('perso' => $perso)),
    $score,
    $score > 1 ? 's' : '',
    get_partial('log/soiree', array('soiree' => $soiree)),
    get_partial('log/statut_soiree', array('statut' => $statut))
);

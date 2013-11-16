<?php

class BMSkillBerserk extends BMSkill {
    public static $name = 'Berserk';
    public static $type = 'Berserk';
    public static $abbrev = 'B';

    public static $hooked_methods = array('attack_list', 'capture');

    public static function attack_list($args) {
        if (!is_array($args)) {
            return;
        }

        $attackTypeArray = &$args['attackTypeArray'];

        if (array_key_exists('Skill', $attackTypeArray)) {
            unset($attackTypeArray['Skill']);
        }

        $attackTypeArray['Berserk'] = 'Berserk';
    }

    public static function capture(&$args) {
        if (!is_array($args)) {
            return;
        }

        if (!array_key_exists('type', $args)) {
            return;
        }

        if ('Berserk' != $args['type']) {
            return;
        }

        if (!array_key_exists('attackers', $args)) {
            return;
        }

        assert(1 == count($args['attackers']));

        $attacker = $args['attackers'][0];
        $skillList = $attacker->skillList;

        // james: which other skills need to be lost after a Berserk attack?
        unset($skillList['Berserk']);

        // force removal of swing status
        $newAttacker = new BMDie();
        $newAttacker->init(round($attacker->max / 2),
                           array_keys($skillList));
        $newAttacker->ownerObject = $attacker->ownerObject;
        $newAttacker->playerIdx = $attacker->playerIdx;
        $newAttacker->originalPlayerIdx = $attacker->originalPlayerIdx;
        $newAttacker->roll(TRUE);
        $args['attackers'][0] = $newAttacker;
    }
}

?>
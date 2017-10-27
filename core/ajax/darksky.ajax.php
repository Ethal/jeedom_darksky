<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

try {
    require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
    include_file('core', 'authentification', 'php');

    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }

    if (init('action') == 'loadingData') {
        if (init('value') == 0) {
            foreach (eqLogic::byType('geotrav', true) as $eqLogic) {
    			$value = $eqLogic->getId();
                exit;
    		}
        } else {
            $value = init('value');
        }
      ajax::success(darksky::loadingData($value));
    }

    if (init('action') == 'getDarksky') {
		foreach (eqLogic::byType('geotrav', true) as $eqLogic) {
			if ($eqLogic->getIsEnable() == 0 || $eqLogic->getIsVisible() == 0) {
				continue;
			}
            $return[] = '<button class="btn btn-default darkskyEqlogic" id="' . $eqLogic->getId() . '" type="button" onClick="loadingData(' . $eqLogic->getId() . ')">' . $eqLogic->getName() . '</button>';
		}
		ajax::success($return);
	}

    throw new Exception(__('Aucune methode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
?>

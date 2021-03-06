<?php
/**
 * ArchFramework (ArchFW in short) is universal template for server-side rendered applications and services.
 * ArchFW comes with pre-installed router and JSON API functionality.
 * Visit https://github.com/archi-tektur/ArchFW/ for more info.
 *
 * PHP version 7.2
 *
 * @category  Framework/Boilerplate
 * @package   ArchFW
 * @author    Oskar 'archi-tektur' Barcz <kontakt@archi-tektur.pl>
 * @copyright 2018 Oskar 'archi_tektur' Barcz
 * @license   MIT https://opensource.org/licenses/MIT
 * @version   2.7.0
 * @link      https://github.com/archi-tektur/ArchFW/
 */

/**
 * Created by PhpStorm.
 * User: Oskar Barcz
 * Date: 08.12.2018
 * Time: 10:17
 */

namespace Game\Controllers;


use ArchFW\Models\DatabaseFactory;

/**
 * Class Choices
 *
 * @package Game\Controllers
 */
class Choices
{
    private $database;

    private $relatedAccountID;

    /**
     * Choices constructor aggigns values
     *
     * @param int $accountID
     */
    public function __construct(int $accountID)
    {
        $this->database = DatabaseFactory::getInstance();
        $this->relatedAccountID = $accountID;
    }

    /**
     * Updates current card info
     *
     * @param int $cardID
     */
    public function updateLC(int $cardID): void
    {
        $this->database->update(
            'choices',
            [
                'currentCardID' => $cardID,
                'lastUpdate'    => date('Y-m-d H:i:s'),
            ],
            [
                'accountID[=]' => $this->relatedAccountID,
            ]
        );
    }

    /**
     * Returns current played act ID
     *
     * @return int|null
     */
    public function getCurrentActID(): ?int
    {
        return $this->database->get(
            'choices',
            [
                'currentActID',
            ],
            [
                'accountID[=]' => $this->relatedAccountID,
            ]
        )['currentActID'];
    }

    /**
     * Returns last seen card ID
     *
     * @return int|null
     */
    public function getCurrentCardID(): ?int
    {
        return $this->database->get(
            'choices',
            [
                'currentCardID',
            ],
            [
                'accountID[=]' => $this->relatedAccountID,
            ]
        )['currentCardID'];
    }

    /**
     * Sets new act ID
     *
     * @param int $actID
     */
    public function setCurrentActID(int $actID): void
    {
        $this->database->update(
            'choices',
            [
                'currentActID' => $actID,
                'lastUpdate'   => date('Y-m-d H:i:s'),
            ],
            [
                'accountID[=]' => $this->relatedAccountID,
            ]
        );
    }

    /**
     * @param int $accountID
     */
    public static function initNewUser(int $accountID): void
    {
        $database = DatabaseFactory::getInstance();
        $database->insert(
            'choices',
            [
                'choiceID'      => null,
                'accountID'     => $accountID,
                'currentActID'  => null,
                'currentCardID' => null,
                'lastUpdate'    => null,
                'gameStartTime' => date('Y-m-d H:i:s'),
            ]
        );
    }
}

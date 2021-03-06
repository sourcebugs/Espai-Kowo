<?php

namespace AppBundle\Manager;

use AppBundle\Entity\ContactMessage;
use AppBundle\Service\NotificationService;
use \DrewM\MailChimp\MailChimp;

/**
 * Class MailchimpManager
 *
 * @category Manager
 * @package  AppBundle\Manager
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class MailchimpManager
{
    /**
     * @var MailChimp $mailChimp
     */
     private $mailChimp;

    /**
     * @var NotificationService
     */
    private $messenger;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * MailchimpManager constructor.
     *
     * @param NotificationService $messenger
     * @param string              $apiKey
     */
    public function __construct(NotificationService $messenger, $apiKey)
    {
        $this->mailChimp = new MailChimp($apiKey);
        $this->messenger = $messenger;
    }

    /**
     * Mailchimp Manager
     *
     * @param ContactMessage $contact
     * @param string         $listId
     *
     * @return boolean       $result
     */
    public function subscribeContactToList(ContactMessage $contact, $listId)
    {
        // evaluate contact name and subscribe
        $explodeName = explode(" ", $contact->getName());
        $mergeFields = array('FNAME' => $explodeName[0]);
        if (count($explodeName) >= 2) {
            $mergeFields['LNAME'] = $explodeName[1];
        }

        // make HTTP API request
        $result = $this->mailChimp->post('lists/' . $listId . '/members', array(
            'email_address' => $contact->getEmail(),
            'status'        => 'subscribed',
            'merge_fields'  => $mergeFields
        ));

        // check error
        if ($result === false) {
            $this->messenger->sendCommonAdminNotification('En ' . $contact->getEmail() . ' no s\'ha pogut registrar a la llista de Mailchimp');
        }

        return $result;
    }
}

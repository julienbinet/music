<?php

namespace AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="music_utilisateurs")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }


    /**
     * @ORM\Column(type="string", length=20)
     *
     */
    protected $telephone;




    /**
    * @ORM\Column(type="string", length=255)
    * @Assert\Url(
    *    message = "The url '{{ value }}' is not a valid url",
    * )
    */

      protected $site;


    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="mesContacts")
     */
    private $friendsWithMe;

    /**
     * @ORM\ManyToMany(targetEntity="User", inversedBy="friendsWithMe")
     * @ORM\JoinTable(name="contacts",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="contact_user_id", referencedColumnName="id")}
     *      )
     */
    private $mesContacts;



    
    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return User
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Add friendsWithMe
     *
     * @param \CarnetBundle\Entity\User $friendsWithMe
     *
     * @return User
     */
    public function addFriendsWithMe(\CarnetBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe[] = $friendsWithMe;

        return $this;
    }

    /**
     * Remove friendsWithMe
     *
     * @param \CarnetBundle\Entity\User $friendsWithMe
     */
    public function removeFriendsWithMe(\CarnetBundle\Entity\User $friendsWithMe)
    {
        $this->friendsWithMe->removeElement($friendsWithMe);
    }

    /**
     * Get friendsWithMe
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriendsWithMe()
    {
        return $this->friendsWithMe;
    }

    /**
     * Add mesContact
     *
     * @param \CarnetBundle\Entity\User $mesContact
     *
     * @return User
     */
    public function addMesContact(\CarnetBundle\Entity\User $mesContact)
    {
        $this->mesContacts[] = $mesContact;

        return $this;
    }

    /**
     * Remove mesContact
     *
     * @param \CarnetBundle\Entity\User $mesContact
     */
    public function removeMesContact(\CarnetBundle\Entity\User $mesContact)
    {
        $this->mesContacts->removeElement($mesContact);
    }

    /**
     * Get mesContacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMesContacts()
    {
        return $this->mesContacts;
    }
}

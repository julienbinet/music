<?php

namespace PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Tag
 *
 * @ORM\Table("music_tag")
 * @ORM\Entity(repositoryClass="PublicBundle\Entity\TagRepository")
 * @ExclusionPolicy("all")
 */
class Tag
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     * @Expose
     */
    private $nom;



    /**
     * @ORM\ManyToMany(targetEntity="PublicBundle\Entity\Artiste", mappedBy="tags")
     * 
     **/
    private $artist;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Tag
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artist = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add artist
     *
     * @param \PublicBundle\Entity\Artiste $artist
     * @return Tag
     */
    public function addArtist(\PublicBundle\Entity\Artiste $artist)
    {
        $this->artist[] = $artist;

        return $this;
    }

    /**
     * Remove artist
     *
     * @param \PublicBundle\Entity\Artiste $artist
     */
    public function removeArtist(\PublicBundle\Entity\Artiste $artist)
    {
        $this->artist->removeElement($artist);
    }

    /**
     * Get artist
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getArtist()
    {
        return $this->artist;
    }
    
        /**
     * Get artist
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function __toString()
    {
        return $this->nom;
    }
    
}

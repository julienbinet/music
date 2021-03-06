<?php

namespace PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * @FileStore\Uploadable
 */

/**
 * Artiste
 *
 * @ORM\Table("music_artiste")
 * @ORM\Entity(repositoryClass="PublicBundle\Entity\ArtisteRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ExclusionPolicy("all") 
 */
class Artiste {

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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Expose
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     * @Expose
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="text")
     * @Expose
     */
    private $bio;

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @ORM\ManyToMany(targetEntity="PublicBundle\Entity\Tag", inversedBy="artist")
     * @ORM\JoinTable(name="music_artist_tags")
     * @MaxDepth(2)
     * @Expose
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="PublicBundle\Entity\Album", mappedBy="artiste")
     * @Expose
     */
    private $albums;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function upload() {


        // la propriété « file » peut être vide si le champ n'est pas requis
        if (null === $this->file) {
            return;
        }

        // la méthode « move » prend comme arguments le répertoire cible et
        // le nom de fichier cible où le fichier doit être déplacé
        $filename = $this->file->getClientOriginalName();

        $filename = strtr($filename, 'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
        //On remplace les lettres accentutées par les non accentuées dans $fichier.
        //Et on récupère le résultat dans fichier
        //En dessous, il y a l'expression régulière qui remplace tout ce qui n'est pas une lettre non accentuées ou un chiffre
        //dans $fichier par un tiret "-" et qui place le résultat dans $fichier.
        $filename = preg_replace('/([^.a-z0-9]+)/i', '-', $filename);
        $filename = rand(0, 1000) . "_" . $filename;

        $this->file->move($this->getUploadRootDir(), $filename);


//        var_dump($this->getUploadRootDir());
        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->image = $filename;

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }

    public function getAbsolutePath() {
        return null === $this->image ? null : $this->getUploadRootDir() . '/' . $this->image;
    }

    public function getWebPath() {
        return null === $this->image ? null : $this->getUploadDir() . '/' . $this->image;
    }

    protected function getUploadRootDir() {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/image dans la vue.
        return 'uploads/photo_artiste';
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Artiste
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom() {
        return $this->nom;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Artiste
     */
    public function setImage($image) {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return Artiste
     */
    public function setPays($pays) {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays() {
        return $this->pays;
    }

    /**
     * Set bio
     *
     * @param string $bio
     * @return Artiste
     */
    public function setBio($bio) {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string 
     */
    public function getBio() {
        return $this->bio;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->tags = new \Doctrine\Common\Collections\ArrayCollection();
        $this->albums = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param \PublicBundle\Entity\Tag $tags
     * @return Artiste
     */
    public function addTag(\PublicBundle\Entity\Tag $tags) {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \PublicBundle\Entity\Tag $tags
     */
    public function removeTag(\PublicBundle\Entity\Tag $tags) {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags() {
        return $this->tags;
    }

    public function __toString() {
        return (string) $this->nom;
    }

    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload() {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated() {
        $this->setUpdated(new \DateTime());
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Artiste
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated() {
        return $this->updated;
    }

    /**
     * Add albums
     *
     * @param \PublicBundle\Entity\Album $albums
     * @return Artiste
     */
    public function addAlbum(\PublicBundle\Entity\Album $albums) {
        $this->albums[] = $albums;

        return $this;
    }

    /**
     * Remove albums
     *
     * @param \PublicBundle\Entity\Album $albums
     */
    public function removeAlbum(\PublicBundle\Entity\Album $albums) {
        $this->albums->removeElement($albums);
    }

    /**
     * Get albums
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAlbums() {
        return $this->albums;
    }

}

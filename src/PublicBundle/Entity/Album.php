<?php

namespace PublicBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Album
 *
 * @ORM\Table("music_album")
 * @ORM\Entity(repositoryClass="PublicBundle\Entity\AlbumRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Album
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="text")
     */
    private $nom;


    /**
     * @ORM\ManyToOne(targetEntity="Artiste", inversedBy="albums")
     * @ORM\JoinColumn(name="id_artiste", referencedColumnName="id")
     */
    private $artiste;

  
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateSortie", type="datetime")
     */
    private $dateSortie;

    /**
     * @var string
     *
     * @ORM\Column(name="chansons", type="text")
     */
    private $chansons;

    /**
     * @var string
     *
     * @ORM\Column(name="pochette", type="string", length=255)
     */
    private $pochette;


        /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;
    
    
    public function __toString() {
        return (string) $this->nom;
    }
    
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
     * @var string
     *
     * @ORM\Column(name="infos", type="text")
     */
    private $infos;



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
        $filename = rand(0, 1000)."_".$filename;

        $this->file->move($this->getUploadRootDir(), $filename);


// var_dump($this->getUploadRootDir());die();

        // définit la propriété « path » comme étant le nom de fichier où vous
        // avez stocké le fichier
        $this->pochette = $filename;

        // « nettoie » la propriété « file » comme vous n'en aurez plus besoin
        $this->file = null;
    }


    public function getAbsolutePath()
    {
        return null === $this->pochette ? null : $this->getUploadRootDir().'/'.$this->pochette;
    }

    public function getWebPath()
    {
        return null === $this->pochette ? null : $this->getUploadDir().'/'.$this->pochette;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // on se débarrasse de « __DIR__ » afin de ne pas avoir de problème lorsqu'on affiche
        // le document/pochette dans la vue.
        return 'uploads/photo_album';
    }




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
     * Set dateSortie
     *
     * @param \DateTime $dateSortie
     * @return Album
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateSortie
     *
     * @return \DateTime 
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * Set chansons
     *
     * @param string $chansons
     * @return Album
     */
    public function setChansons($chansons)
    {
        $this->chansons = $chansons;

        return $this;
    }

    /**
     * Get chansons
     *
     * @return string 
     */
    public function getChansons()
    {
        return $this->chansons;
    }

    /**
     * Set pochette
     *
     * @param string $pochette
     * @return Album
     */
    public function setPochette($pochette)
    {
        $this->pochette = $pochette;

        return $this;
    }

    /**
     * Get pochette
     *
     * @return string 
     */
    public function getPochette()
    {
        return $this->pochette;
    }

  

    /**
     * Set nom
     *
     * @param string $nom
     * @return Album
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
     * Set infos
     *
     * @param string $infos
     * @return Album
     */
    public function setInfos($infos)
    {
        $this->infos = $infos;

        return $this;
    }

    /**
     * Get infos
     *
     * @return string 
     */
    public function getInfos()
    {
        return $this->infos;
    }

    /**
     * Set artiste
     *
     * @param \PublicBundle\Entity\Artiste $artiste
     * @return Album
     */
    public function setArtiste(\PublicBundle\Entity\Artiste $artiste = null)
    {
        $this->artiste = $artiste;

        return $this;
    }

    /**
     * Get artiste
     *
     * @return \PublicBundle\Entity\Artiste 
     */
    public function getArtiste()
    {
        return $this->artiste;
    }
    
    

    
    
    
}

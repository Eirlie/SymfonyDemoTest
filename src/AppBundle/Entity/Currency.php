<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Currency
 * @ORM\Table(name="symfony_demo_currency")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CurrencyRepository")
 * @UniqueEntity(fields={"numCode"}, message="currency.unique.num_code")
 * @UniqueEntity(fields={"charCode"}, message="currency.unique.char_code")
 * @UniqueEntity(fields={"name"}, message="currency.unique.name")
 * @author Eldar Shikhbadinov <s.eldar@ideas-world.net>
 */
class Currency
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="numCode", type="string", length=3, unique=true)
     * @Assert\Type(type="string", message="currency.num_code.type")
     * @Assert\Regex(pattern="/^\d{3}$/", message="currency.num_code.regex")
     */
    private $numCode;

    /**
     * @var string
     * @ORM\Column(name="charCode", type="string", length=3, unique=true)
     * @Assert\Type(type="string", message="currency.char_code.type")
     * @Assert\Regex(pattern="/^[A-Z]{3}$/", message="currency.char_code.regex")
     */
    private $charCode;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Type(type="string", message="currency.name.type")
     * @Assert\Length(max="255", maxMessage="currency.name.length")
     */
    private $name;

    /**
     * @var double
     * @ORM\Column(name="rateToRuble", type="decimal", precision=4, scale=11)
     * @Assert\Type(type="double", message="currency.rate_to_ruble.type")
     * @Assert\GreaterThan(value="0", message="currency.rate_to_ruble.grater_than")
     */
    private $rateToRuble;

    /**
     * @var bool
     * @ORM\Column(name="isDefault", type="boolean", options={"default":0})
     * @Assert\Type(type="boolean", message="currency.default.type")
     */
    private $default = false;

    /**
     * @var Post[]
     * @ORM\OneToMany(targetEntity="Post", mappedBy="currency", orphanRemoval=true, fetch="EXTRA_LAZY")
     * @ORM\OrderBy({"publishedAt" = "DESC"})
     */
    private $posts;

    /**
     * @var Collection<User>
     * @ORM\OneToMany(targetEntity="User", mappedBy="defaultCurrency", orphanRemoval=false, fetch="EXTRA_LAZY")
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return boolean
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * @param boolean $default
     */
    public function setDefault($default)
    {
        $this->default = (bool)$default;
    }

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get numCode
     * @return int
     */
    public function getNumCode()
    {
        return $this->numCode;
    }

    /**
     * Set numCode
     *
     * @param int $numCode
     *
     * @return Currency
     */
    public function setNumCode($numCode)
    {
        $this->numCode = $numCode;

        return $this;
    }

    /**
     * Get charCode
     * @return string
     */
    public function getCharCode()
    {
        return $this->charCode;
    }

    /**
     * Set charCode
     *
     * @param string $charCode
     *
     * @return Currency
     */
    public function setCharCode($charCode)
    {
        $this->charCode = strtoupper($charCode);

        return $this;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Currency
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get rateToRuble
     * @return double
     */
    public function getRateToRuble()
    {
        return $this->rateToRuble;
    }

    /**
     * Set rateToRuble
     *
     * @param double $rateToRuble
     *
     * @return Currency
     */
    public function setRateToRuble($rateToRuble)
    {
        $this->rateToRuble = (double)$rateToRuble;

        return $this;
    }

    /**
     * Add posts
     *
     * @param \AppBundle\Entity\Post $posts
     *
     * @return Currency
     */
    public function addPost(\AppBundle\Entity\Post $posts)
    {
        $this->posts[] = $posts;

        return $this;
    }

    /**
     * Remove posts
     *
     * @param \AppBundle\Entity\Post $posts
     */
    public function removePost(\AppBundle\Entity\Post $posts)
    {
        $this->posts->removeElement($posts);
    }

    /**
     * Get posts
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Currency
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \AppBundle\Entity\User $user
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }
}

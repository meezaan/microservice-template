<?php
namespace Book\Entity;

/**
 * @Entity @Table(name="book", indexes={@Index(name="book_idx", columns={"id"}), @Index(name="name_x", columns={"name"})})
 **/
class Book
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     **/
    protected $id;

    /**
     * @Column(type="integer", length=10, nullable=false)
     **/
    protected $pages;

    /**
     * @Column(type="integer", name="chapters", length=5, nullable=false)
     **/
    protected $chapters;

    /**
     * @Column(type="string", length=500, nullable=false)
     **/
    protected $name;


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
     * Set pages
     *
     * @param integer $pages
     *
     * @return Book
     */
    public function setPages($pages)
    {
        $this->pages = $pages;

        return $this;
    }

    /**
     * Get pages
     *
     * @return integer
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set chapters
     *
     * @param integer $chapters
     *
     * @return Book
     */
    public function setChapters($chapters)
    {
        $this->chapters = $chapters;

        return $this;
    }

    /**
     * Get chapters
     *
     * @return integer
     */
    public function getChapters()
    {
        return $this->chapters;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Book
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

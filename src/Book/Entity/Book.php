<?php
// entity/Ayat.php

namespace Book\Entity;


/**
 * @Entity @Table(name="book", indexes={@Index(name="book_idx", columns={"book_id"}), @Index(name="name_x", columns={"name"})})
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
    protected $pafges;

    /**
     * @Column(type="integer", name="chapters", length=5, nullable=false)
     **/
    protected $chapters;

    /**
     * @Column(type="string", length=64000, nullable=false)
     **/
    protected $name;

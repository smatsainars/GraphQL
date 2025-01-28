<?php

namespace App\Schema\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 */
class Product {
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $inStock;

    /**
     * @ORM\Column(type="json")
     */
    private $gallery;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_name", referencedColumnName="name")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="Price", mappedBy="product", cascade={"persist"})
     */
    private $prices;

    /**
     * @ORM\OneToMany(targetEntity="AttributeSet", mappedBy="product", cascade={"persist"})
     */
    private $attributes;

    // Getters, setters, constructor
}
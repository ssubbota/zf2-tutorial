<?php
namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation;

use Doctrine\Common\Annotations\AnnotationRegistry;
//$pathToZF2Library = __DIR__.'/../../../../../vendor/ZF2/library/';
//AnnotationRegistry::registerAutoloadNamespace('Zend\Form\Annotation', $pathToZF2Library);

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @property string $name
 * @property string $email
 * @property int $id
 * @property string $phone
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ObjectProperty")
 * @Annotation\Name("User")
 */
class User {
    
    /** 
    * @ORM\Id @ORM\Column(type="integer")
    * @ORM\GeneratedValue(strategy="AUTO")
    * @Annotation\Type("Zend\Form\Element\Hidden")
    */
    protected $id;

    /** 
    * @ORM\Column(type="string")
    * @Annotation\Type("Zend\Form\Element\Text")
    * @Annotation\Filter({"name":"StripTags"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"Alnum", "options": {"allowWhiteSpace":"true"}})
    * @Annotation\Validator({"name":"StringLength", "options": {"min":"2", "max":"25"}})
    * @Annotation\Options({"label":"Username: "})
    */
    protected $name;

    /** 
    * @ORM\Column(type="string")
    * @Annotation\Type("Zend\Form\Element\Email")
    * @Annotation\Filter({"name":"StripTags"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Validator({"name":"EmailAddress", "options": {"domain":"true"}})
    * @Annotation\Options({"label":"Email: "})
    */
    protected $email;

    /** 
    * @ORM\Column(type="string")
    * @Annotation\Type("Zend\Form\Element\Password")
    * @Annotation\Filter({"name":"StripTags"})
    * @Annotation\Filter({"name":"StringTrim"})
    * @Annotation\Options({"label":"Password: "})
    */
    protected $phone;

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }
}
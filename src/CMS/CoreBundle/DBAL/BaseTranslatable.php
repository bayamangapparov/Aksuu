<?php


namespace CMS\CoreBundle\DBAL;


use Prezent\Doctrine\Translatable\Entity\AbstractTranslatable;
use Prezent\Doctrine\Translatable\Annotation as Prezent;

abstract class BaseTranslatable extends AbstractTranslatable {



    /**
     * @Prezent\CurrentLocale
     */
    protected  $currentLocale;


    protected  $currentTranslation; // Cache current translation. Useful in Doctrine 2.4+


    /**
     * Translation helper method
     */
    protected  function translate($locale = null)
    {
        if (null === $locale) {
            $locale = $this->currentLocale;
        }

        if (!$locale) {
            throw new \RuntimeException('No locale has been set and currentLocale is empty');
        }

        if ($this->currentTranslation && $this->currentTranslation->getLocale() === $locale) {
            return $this->currentTranslation;
        }

        if (!$translation = $this->translations->get($locale)) {
            $translationClass = get_class($this).'Translation';
            $translation = new $translationClass();
            $translation->setLocale($locale);
            $this->addTranslation($translation);
        }

        $this->currentTranslation = $translation;
        return $translation;
    }

    protected function getFieldTranslation($field)
    {
        $method = 'get'.ucfirst($field);
        if ($trans = $this->translate()->$method())
            return $trans;
        else
            return $this->translate('ru')->$method();
    }
}
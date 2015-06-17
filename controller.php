<?php

defined('C5_EXECUTE') or die('Access Denied.');

class SeoFilesPackage extends Package
{
    protected $pkgHandle = 'seo_files';
    protected $appVersionRequired = '5.6.3.1';
    protected $pkgVersion = '1.0.0';

    public function getPackageName()
    {
        return t('SEO Files');
    }

    public function getPackageDescription()
    {
        return t('Installs a dashboard page where you can rename existing files');
    }

    protected function installXmlContent()
    {
        $pkg = Package::getByHandle($this->pkgHandle);

        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
    }

    public function install()
    {
        parent::install();
        $this->installXmlContent();
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->installXmlContent();
    }
}

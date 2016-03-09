<?php

namespace WebLinks\Tests;

require_once __DIR__.'/../../vendor/autoload.php';

use Silex\WebTestCase;

/**
 * Class to test all URLs of the application with a unit test game
 * 
 * @author      Christophe Malo
 * @version     1.0.0
 * @copyright   OpenClassrooms - Baptiste Pesquet
 * 
 * @commentaire Use prod config for unit tests.
 *              The config Dev (monolog info + debug) generates errors with phpunit.
 */

class AppTest extends WebTestCase
{
    
    /** 
     * Basic, application-wide functional test inspired by Symfony best practices.
     * Simply checks that all application URLs load successfully.
     * During test execution, this method is called for each URL returned by the provideUrls method.
     *
     * @dataProvider provideUrls 
     */
    public function testPageIsSuccessful($url)
    {
        $client = $this->createClient();
        $client->request('GET', $url);

        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    /**
     * {@inheritDoc}
     */
    public function createApplication()
    {
        // Instantie, configure et renvoit l'application
        $app = new \Silex\Application();
        
        require __DIR__.'/../../app/config/prod.php'; // For php unit
        require __DIR__.'/../../app/app.php';
        require __DIR__.'/../../app/routes.php';
        
        // Generate raw exceptions instead of HTML pages if errors occur
        $app['exception_handler']->disable();
        // Simulate sessions for testing
        $app['session.test'] = true;
        // Enable anonymous access to admin zone
        $app['security.access_rules'] = array();

        return $app;
    }

    /**
     * Provides all valid application URLs
     *
     * @return array array The list of all valid application URLs
     */
    public function provideUrls()
    {
        return array(
            array('/'),
            array('/login'),
            array('/userarea/link/submit'),
            array('/admin'),
            array('/admin/link/1/edit'),
            array('/admin/user/add'),
            array('/admin/user/1/edit'),
        ); 
    }
    
}

<?php
/**
 * Web Controller
 * Simple convention based web controller to auto route actions
 *
 * @package     erdiko/controllers
 * @copyright   2012-2017 Arroyo Labs, Inc. http://www.arroyolabs.com
 * @author      John Arroyo <john@arroyolabs.com>
 */
namespace erdiko\controllers;


class Web extends \erdiko\Controller
{
    /**
     * Invoke 
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return string $action method name 
     */
    public function __invoke($request, $response, $args) 
    {
        $action = $this->determineAction($request, $args);
        // $this->container->logger->debug("Controller action: ".print_r($action, true));
        $this->$action($request, $response, $args);
    }

    /**
     * Determine action
     * 
     * @param Request $request
     * @param array $args
     * @return string $action method name 
     */
    protected function determineAction($request, $args) : string
    {
        // Request method
        $action = strtolower($request->getMethod());
        // Action
        $action .= empty($args['action']) ? "" : ucfirst($args['action']);

         // @todo trigger 404 instead of throw exception
        if(!method_exists($this, $action))
            throw new \Exception("action does not exist");

        return $action;
    }

    /**
     * Render 
     * Render page based off of the application and theme configs
     * At todo move to a trait, \erdiko\theme\traits\Controller
     */ 
    public function render($response, $view = null, \erdiko\theme\Engine $themeEngine = null) 
    {
        if(empty($themeEngine))
            $themeEngine = new \erdiko\theme\Engine;

        if(empty($view)) {
            $view = $themeEngine->getDefaultView();
        }
        // $this->container->logger->debug("view: {$view}");

        return $this->container->theme->render($response, $view, $themeEngine->toArray());
    }
}

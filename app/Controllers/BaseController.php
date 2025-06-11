<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\RoleModel;
use Constants;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * initiate variable caching
     */
    protected $role;

    /**
     * Data yang akan dikirim ke layout.
     * @var array
     */
    protected $data = []; // Properti untuk data yang akan dikirim ke layout
    

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $cache = \Config\Services::cache();
        

        // Preload any models, libraries, etc, here.
        // E.g.: $this->session = service('session');

        // do caching master data
        // set cache role with hashmap
        $roleHashMapCache = $cache->get(Constants::ROLE_KEY_HASHMAP);
        error_log("isi cache role");
        error_log(json_encode($roleHashMapCache));
        $roleModel = new RoleModel();
        if($roleHashMapCache == null){
            //get all data role
            $role = $roleModel->findAll();
            foreach($role as $value){
                $roleHashMapCache[$value['value']] = $value;
            }
            error_log("save cache role");
            error_log("========================");
            error_log(json_encode($roleHashMapCache));
            error_log("========================");

            //save cache role
            $cache->save(Constants::ROLE_KEY_HASHMAP, $roleHashMapCache);
        }

        //set cache role all tanpa hash map
        $roleCache = $cache->get(Constants::ROLE_KEY);
        if($roleCache == null){
            $roleCache = $roleModel->findAll();
            $cache->save(Constants::ROLE_KEY, $roleCache);
        }
        
    }
}

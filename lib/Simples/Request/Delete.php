<?php
namespace Simples\Request ;

/**
 * Delete and object.
 *
 * @author Sébastien Charrier <scharrier@gmail.com>
 * @package    Simples
 * @subpackage Request
 */
class Delete extends \Simples\Request {

    /**
     * Definition
     *
     * @var array
     */
    protected $_definition = array(
        'method' => self::DELETE,
        'required' => array(
            'body' => array('id'),
            'options' => array('index','type')
        ),
        'magic' => 'id',
        'inject' => array(
            'params' => array('refresh'),
        )
    ) ;

    /**
     * Request options :
     * - refresh (bool) : should we wait the index refresh before continuing ?
     *
     * @var array
     */
    protected $_options = array(
        'refresh' => null,
    ) ;

    /**
     * Path : id management.
     *
     * @return string    API path
     */
    public function path() {
        $path = parent::path() ;

        // Object id transmited : we add it to the url.
        if (isset($this->_body['id'])) {
            $path->directory($this->_body['id']) ;
        }

        return $path ;
    }
}

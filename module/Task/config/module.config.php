<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Task\Controller\Task' => 'Task\Controller\TaskController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
			'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Task\Controller\Task',
                        'action'     => 'index',
                    ),
                ),
            ),
			
            'task' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/task[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Task\Controller\Task',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
	
	'service_manager' => array(
    'factories' => array(
        'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory', 
		),
	),
	
	'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
	
    'view_manager' => array(
        'template_path_stack' => array(
            'task' => __DIR__ . '/../view',
			 'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        ),
    ),
	
	
	
	'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'task/index/index' => __DIR__ . '/../view/task/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
           'task' => __DIR__ . '/../view',
        ),
    ),
	
	'navigation' => array(
    'default' => array(
        array(
            'label' => 'New task',
            'route' => 'task',	
			'action' => 'add',
			'params' => array('b'=> 1),
			
        ),
    ),
)
);
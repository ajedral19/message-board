# Social Application

## Naming Convention
1. Views, Classes and Controller classes must be name in **PascalCase**
2. Controller actions or static methods must be in **camelCase**
3. Not-instantiating Class methods must be named in **snake_case**


## Adding Routes
```
$module = [
  'controller' => 'Controller',
  'action' => 'controllerStaticMethod'
];
$router->route('method', '/uri', 'View', $module);
```
- method
- /uri
- View
- Controller
- controllerStaticMethod

## How to use


## How it works

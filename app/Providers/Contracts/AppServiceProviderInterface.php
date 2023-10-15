<?php

declare(strict_types=1);

namespace App\Providers\Contracts;

interface AppServiceProviderInterface
{
    /**
     * @description We can register a binding using the bind method, passing the class or interface name that
     * we wish to register along with a Closure that returns an instance of the class.
     */
    public const SERVICE_BIND = 'bind';

    /**
     * @description The extend method allows the modification of resolved services.
     * For example, when a service is resolved, you may run additional code to decorate or configure the service.
     */
    public const SERVICE_EXTEND = 'extend';

    /**
     * @description Occasionally, you may need to resolve all of a certain "category" of binding.
     * For example, perhaps you are building a report aggregator that receives an array of many different Report interface implementations.
     * After registering the Report implementations, you can assign them a tag using the tag method.
     */
    public const SERVICE_TAG = 'tag';

    /**
     * @description The singleton method binds a class or interface into the container that should only be resolved one time.
     * Once a singleton binding is resolved, the same object instance will be returned on subsequent calls into the container.
     */
    public const SERVICE_SINGLETON = 'singleton';

    /**
     * @description Register any application service provider
     */
    public const SERVICE_REGISTER = 'register';
}

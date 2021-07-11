<?php


namespace App\DependencyInjection\Compiler;


use App\Service\FirstClassService;
use App\Service\RandomNumberService;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ReshaPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition(RandomNumberService::class)->setPublic(true);

        $firstClassService = $container->findDefinition(FirstClassService::class);

      $services =  $container->findTaggedServiceIds('app.RESHA');

      foreach ( $services as $id => $service)
      {
          $firstClassService->addMethodCall('addService',[new Reference($id)]);
      }

    }
}
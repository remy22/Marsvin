<?php
namespace Marsvin;

use Evenement\EventEmitter;
use Spork\ProcessManager;
use Marsvin\Provider;
use Marsvin\Provider\Adapter\DefaultAdapter as ProviderDefaultAdapter;

class Marsvin
{
 
    private $event;

    private $provider;

    private $process;

    public function __construct(EventEmitter $event = null, ProcessManager $process = null, ProviderInterface $provider = null)
    {
        $this->event = $event ?: new EventEmitter();
        $this->process = $process ?: new ProcessManager();
        $this->provider = $provider ?: new Provider(new ProviderDefaultAdapter($event, $process));
    }

    public function request($handle)
    {
        $this->provider->getRequester()->setHandle($handle);

        return $this;
    }

    public function parse($handle)
    {
        $this->provider->getParser()->setHandle($handle);

        return $this;
    }

    public function persist($handle)
    {
        $this->provider->getPersister()->setHandle($handle);

        return $this;
    }


    public function run()
    {
        $this->provider->import();
    }

}
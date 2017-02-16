<?php

namespace AsyncPHP\Doorman\Task;

use AsyncPHP\Doorman\Task;
use Closure;
use SuperClosure\SerializableClosure;

class CallbackTask implements Task
{
    /**
     * @var Closure
     */
    private $closure;

    /**
     * @param Closure $closure
     */
    public function __construct(Closure $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function serialize()
    {
        $closure = new SerializableClosure($this->closure);

        return serialize($closure);
    }

    /**
     * @inheritdoc
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        /** @var SerializableClosure $closure */
        $closure = unserialize($serialized);

        $this->closure = $closure->getClosure();
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getData(): array
    {
        return [
            "closure" => $this->closure,
        ];
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getHandler(): string
    {
        return "AsyncPHP\\Doorman\\Handler\\CallbackHandler";
    }

    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function ignoresRules(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function stopsSiblings(): bool
    {
        return false;
    }

    /**
     * @inheritdoc
     *
     * @return bool
     */
    public function canRunTask(): bool
    {
        return true;
    }
}

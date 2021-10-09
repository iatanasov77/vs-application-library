<?php namespace VS\ApplicationBundle\Component\Context;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Sylius\Component\Channel\Context\ChannelNotFoundException;
use Sylius\Component\Channel\Model\ChannelInterface;

final class ApplicationContext implements ChannelContextInterface
{
    private RequestResolverInterface $requestResolver;

    private RequestStack $requestStack;

    public function __construct(RequestResolverInterface $requestResolver, RequestStack $requestStack)
    {
        $this->requestResolver = $requestResolver;
        $this->requestStack = $requestStack;
    }

    public function getChannel(): ChannelInterface
    {
        try {
            return $this->getChannelForRequest($this->getMasterRequest());
        } catch (\UnexpectedValueException $exception) {
            throw new ChannelNotFoundException(null, $exception);
        }
    }

    private function getChannelForRequest(Request $request): ChannelInterface
    {
        $channel = $this->requestResolver->findChannel($request);

        $this->assertChannelWasFound($channel);

        return $channel;
    }

    private function getMasterRequest(): Request
    {
        $masterRequest = $this->requestStack->getMasterRequest();
        if (null === $masterRequest) {
            throw new \UnexpectedValueException('There are not any requests on request stack');
        }

        return $masterRequest;
    }

    private function assertChannelWasFound(?ChannelInterface $channel): void
    {
        if (null === $channel) {
            throw new \UnexpectedValueException('Channel was not found for given request');
        }
    }
}

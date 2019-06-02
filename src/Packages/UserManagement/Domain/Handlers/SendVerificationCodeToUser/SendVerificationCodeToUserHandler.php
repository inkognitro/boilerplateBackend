<?php declare(strict_types=1);

namespace App\Packages\UserManagement\Domain\Handlers\SendVerificationCodeToUser;

use App\Packages\Common\Domain\Mailing\Mailer;
use App\Packages\UserManagement\Application\SendVerificationCodeToUser;
use App\Packages\UserManagement\Domain\UserByIdQuery;
use App\Packages\UserManagement\Domain\UserEventDispatcher;
use App\Resources\User\UserId;
use App\Utilities\HandlerResponse\Response;
use App\Utilities\HandlerResponse\SuccessResponse;
use App\Utilities\HandlerResponse\ValidationErrorResponse;
use App\Utilities\Validation\Messages\DoesNotExistMessage;
use App\Utilities\Validation\Messages\MessageBag;

final class SendVerificationCodeToUserHandler
{
    private $userEventDispatcher;
    private $userByIdQuery;
    private $mailer;

    public function __construct(UserEventDispatcher $userEventDispatcher, UserByIdQuery $userByIdQuery, Mailer $mailer)
    {
        $this->userEventDispatcher = $userEventDispatcher;
        $this->userByIdQuery = $userByIdQuery;
        $this->mailer = $mailer;
    }

    public function handle(SendVerificationCodeToUser $command): Response
    {
        $user = $this->userByIdQuery->execute(UserId::fromString($command->getUserId()));
        if($user === null) {
            $warnings = MessageBag::createEmpty();
            $errors = MessageBag::createEmpty()->addMessage(UserId::getKey(), new DoesNotExistMessage());
            return new ValidationErrorResponse($errors, $warnings);
        }


        $subject = 'Verification';
        $link = getenv('APP_WEBFRONTEND_VERIFICATION_URL');
        $link = str_replace('%verificationCode%', urlencode($command->getVerificationCode()), $link);
        $content = str_replace('%link%', $link, file_get_contents('./template.html'));
        $this->mailer->send($user->getEmailAddress()->toString(), $subject, $content);
        return SuccessResponse::create();
    }
}
<?php

declare(strict_types=1);

namespace HomeCalculator;

use HomeCalculator\Provider\Core\ProviderInterface;

final class App
{
    public const string FORM_CALCULATOR = 'CALCULATOR';

    public const string FORM_REQUESTS = 'REQUESTS';

    private readonly string $name;

    /**
     * @var array<int, ProviderInterface>
     */
    private array $providers;

    private function __construct(array $providers)
    {
        $this->name = "Калькулятор коммунальных услуг";
        $this->providers = $providers;
    }

    public static function init(array $providers): self
    {
        static $instance;
        return $instance ??= new self($providers);
    }

    public function activateSecurity(): void
    {
        $this->activateCSRFSecurity();

    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<int, ProviderInterface>
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    public function generateFormToken($formKey): string
    {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_tokens'][$formKey] = $token;

        return $token;
    }

    private function activateCSRFSecurity(): void
    {
        if (!isset($_SESSION['csrf_tokens'])) {
            $_SESSION['csrf_tokens'] = [];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tokens = [
                self::FORM_CALCULATOR => $_POST['csrf_token_calculator'] ?? '',
                self::FORM_REQUESTS => $_POST['csrf_token_requests'] ?? '',
            ];

            foreach ($tokens as $idx => $receivedToken) {
                if (empty($receivedToken)) {
//                    session_destroy();
                    die($this->errorPage('Неизвестная форма.'));
                }

                if (
                    !isset($_SESSION['csrf_tokens'][$idx])
                    || $_SESSION['csrf_tokens'][$idx] !== $receivedToken
                ) {
//                    session_destroy();
                    die($this->errorPage('Некорректный CSRF токен для формы.'));
                }

//                unset($_SESSION['csrf_tokens'][$idx]);
            }
        }

        var_dump($_SESSION);
        var_dump($_SERVER);
    }

    private function errorPage(string $errorMessage): string
    {
        return <<<HTML
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Error</title>
    </head>
    <body>
        <h1>Oops! <?= $errorMessage ?></h1>
    </body>
</html>
HTML;
    }
}
<?php declare(strict_types=1);

namespace App\Controllers;

abstract class AbstractController
{
    /**
     * Rend une vue avec des données
     */
    protected function render(string $template, array $data = []): void
    {
        extract($data);
        $templatePath = __DIR__ . '/../views/' . $template . '.php';

        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template non trouvé: $template");
        }

        require $templatePath;
    }

    /**
     * Redirige vers une URL
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit;
    }

    /**
     * Retourne une réponse JSON
     */
    protected function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    /**
     * Valide des données selon des règles
     *
     * Règles supportées:
     * - required: Champ obligatoire
     * - email: Format email valide
     * - min:X: Longueur minimale
     * - max:X: Longueur maximale
     *
     * @param array $data Données à valider
     * @param array $rules Règles de validation ['field' => 'required|email|min:3']
     * @return array Tableau des erreurs ['field' => 'message d\'erreur']
     */
    protected function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $fieldRules = explode('|', $ruleString);

            foreach ($fieldRules as $rule) {
                // Règle: required
                if ($rule === 'required' && empty($data[$field])) {
                    $errors[$field] = "Le champ $field est requis";
                    break; // Pas besoin de valider les autres règles si vide
                }

                // Règle: email
                if ($rule === 'email' && !empty($data[$field])) {
                    if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field] = "Le champ $field doit être un email valide";
                    }
                }

                // Règle: min:X
                if (preg_match('/^min:(\d+)$/', $rule, $matches)) {
                    $min = (int)$matches[1];
                    if (isset($data[$field]) && strlen($data[$field]) < $min) {
                        $errors[$field] = "Le champ $field doit contenir au moins $min caractères";
                    }
                }

                // Règle: max:X
                if (preg_match('/^max:(\d+)$/', $rule, $matches)) {
                    $max = (int)$matches[1];
                    if (isset($data[$field]) && strlen($data[$field]) > $max) {
                        $errors[$field] = "Le champ $field ne doit pas dépasser $max caractères";
                    }
                }
            }
        }

        return $errors;
    }

    /**
     * Vérifie si l'utilisateur est authentifié
     */
    protected function isAuthenticated(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['username']);
    }

    /**
     * Démarre la session si ce n'est pas déjà fait
     */
    protected function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
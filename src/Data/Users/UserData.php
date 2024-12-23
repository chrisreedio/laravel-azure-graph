<?php

namespace ChrisReedIO\AzureGraph\Data\Users;

use function array_key_exists;

readonly class UserData
{
    public function __construct(
        public ?string $id = null,
        public ?bool $accountEnabled = null,
        public ?string $userPrincipalName = null,
        public ?string $displayName = null,
        public ?string $givenName = null,
        public ?string $surname = null,
        public ?string $mobilePhone = null,
        public ?array $businessPhones = null,
        public ?string $mail = null,
        public ?string $department = null,
        public ?string $companyName = null,
        public ?string $jobTitle = null,
        public ?string $officeLocation = null,
        public ?string $userType = null,
        public ?string $employeeId = null,
        public ?UserData $manager = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            accountEnabled: $data['accountEnabled'] ?? null,
            userPrincipalName: $data['userPrincipalName'] ?? null,
            displayName: $data['displayName'] ?? null,
            givenName: $data['givenName'] ?? null,
            surname: $data['surname'] ?? null,
            mobilePhone: $data['mobilePhone'] ?? null,
            businessPhones: $data['businessPhones'] ?? null,
            mail: $data['mail'] ?? null,
            department: $data['department'] ?? null,
            companyName: $data['companyName'] ?? null,
            jobTitle: $data['jobTitle'] ?? null,
            officeLocation: $data['officeLocation'] ?? null,
            userType: $data['userType'] ?? null,
            employeeId: $data['employeeId'] ?? null,
            manager: array_key_exists('manager', $data) ? self::fromArray($data['manager']) : null,
        );
    }
}

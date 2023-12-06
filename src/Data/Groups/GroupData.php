<?php

namespace ChrisReedIO\AzureGraph\Data\Groups;

readonly class GroupData
{
    const TYPE = '#microsoft.graph.group';
    public function __construct(
        public ?string $id,
        public ?string $deletedDateTime,
        public ?string $classification,
        public ?string $createdDateTime,
        public ?array $creationOptions,
        public ?string $description,
        public ?string $displayName,
        public ?string $expirationDateTime,
        public ?array $groupTypes,
        public ?bool $isAssignableToRole,
        public ?string $mail,
        public ?bool $mailEnabled,
        public ?string $mailNickname,
        public ?string $membershipRule,
        public ?string $membershipRuleProcessingState,
        public ?string $onPremisesDomainName,
        public ?string $onPremisesLastSyncDateTime,
        public ?string $onPremisesNetBiosName,
        public ?string $onPremisesSamAccountName,
        public ?string $onPremisesSecurityIdentifier,
        public ?bool $onPremisesSyncEnabled,
        public ?string $preferredDataLocation,
        public ?string $preferredLanguage,
        public ?array $proxyAddresses,
        public ?string $renewedDateTime,
        public ?array $resourceBehaviorOptions,
        public ?array $resourceProvisioningOptions,
        public ?bool $securityEnabled,
        public ?string $securityIdentifier,
        public ?string $theme,
        public ?string $visibility,
        public ?array $onPremisesProvisioningErrors,
        public ?array $serviceProvisioningErrors
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            deletedDateTime: $data['deletedDateTime'] ?? null,
            classification: $data['classification'] ?? null,
            createdDateTime: $data['createdDateTime'] ?? null,
            creationOptions: $data['creationOptions'] ?? null,
            description: $data['description'] ?? null,
            displayName: $data['displayName'] ?? null,
            expirationDateTime: $data['expirationDateTime'] ?? null,
            groupTypes: $data['groupTypes'] ?? null,
            isAssignableToRole: $data['isAssignableToRole'] ?? null,
            mail: $data['mail'] ?? null,
            mailEnabled: $data['mailEnabled'] ?? null,
            mailNickname: $data['mailNickname'] ?? null,
            membershipRule: $data['membershipRule'] ?? null,
            membershipRuleProcessingState: $data['membershipRuleProcessingState'] ?? null,
            onPremisesDomainName: $data['onPremisesDomainName'] ?? null,
            onPremisesLastSyncDateTime: $data['onPremisesLastSyncDateTime'] ?? null,
            onPremisesNetBiosName: $data['onPremisesNetBiosName'] ?? null,
            onPremisesSamAccountName: $data['onPremisesSamAccountName'] ?? null,
            onPremisesSecurityIdentifier: $data['onPremisesSecurityIdentifier'] ?? null,
            onPremisesSyncEnabled: $data['onPremisesSyncEnabled'] ?? null,
            preferredDataLocation: $data['preferredDataLocation'] ?? null,
            preferredLanguage: $data['preferredLanguage'] ?? null,
            proxyAddresses: $data['proxyAddresses'] ?? null,
            renewedDateTime: $data['renewedDateTime'] ?? null,
            resourceBehaviorOptions: $data['resourceBehaviorOptions'] ?? null,
            resourceProvisioningOptions: $data['resourceProvisioningOptions'] ?? null,
            securityEnabled: $data['securityEnabled'] ?? null,
            securityIdentifier: $data['securityIdentifier'] ?? null,
            theme: $data['theme'] ?? null,
            visibility: $data['visibility'] ?? null,
            onPremisesProvisioningErrors: $data['onPremisesProvisioningErrors'] ?? null,
            serviceProvisioningErrors: $data['serviceProvisioningErrors'] ?? null
        );
    }
}

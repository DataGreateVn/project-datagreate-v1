<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Tag(name: 'Translations', description: 'DB i18n')]
class TranslationsDocs
{
    #[OA\Get(
        path: '/api/i18n/{locale}/{group}',
        tags: ['Translations'],
        summary: 'Get key=>value by locale & group (public)',
        parameters: [
            new OA\Parameter(
                name: 'locale',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string'),
                example: 'vi'
            ),
            new OA\Parameter(
                name: 'group',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'string'),
                example: 'homepage'
            ),
            new OA\Parameter(
                name: 'namespace',
                in: 'query',
                schema: new OA\Schema(type: 'string'),
                example: '*'
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'OK',
                content: new OA\JsonContent(
                    type: 'object',
                    // ✅ ĐÚNG: additionalProperties phải là AdditionalProperties|bool|null
                    additionalProperties: new OA\AdditionalProperties(type: 'string')
                )
            )
        ]
    )]
    public function fetchGroup() {}

    #[OA\Get(
        path: '/api/admin/i18n',
        tags: ['Translations'],
        summary: 'List translations (admin, filters + paginate)',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'q', in: 'query', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'locale', in: 'query', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'namespace', in: 'query', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'group', in: 'query', schema: new OA\Schema(type: 'string')),
            new OA\Parameter(name: 'page', in: 'query', schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'per_page', in: 'query', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'OK')
        ]
    )]
    public function listAdmin() {}

    #[OA\Post(
        path: '/api/admin/i18n',
        tags: ['Translations'],
        summary: 'Create translation',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                type: 'object',
                required: ['locale', 'group', 'key'],
                properties: [
                    new OA\Property(property: 'locale', type: 'string', example: 'vi'),
                    new OA\Property(property: 'namespace', type: 'string', example: '*'),
                    new OA\Property(property: 'group', type: 'string', example: 'homepage'),
                    new OA\Property(property: 'key', type: 'string', example: 'hero.title'),
                    new OA\Property(property: 'value', type: 'string', example: 'Xin chào'),
                ],
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Created')
        ]
    )]
    public function create() {}

    #[OA\Put(
        path: '/api/admin/i18n/{id}',
        tags: ['Translations'],
        summary: 'Update translation by id',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'locale', type: 'string'),
                    new OA\Property(property: 'namespace', type: 'string'),
                    new OA\Property(property: 'group', type: 'string'),
                    new OA\Property(property: 'key', type: 'string'),
                    new OA\Property(property: 'value', type: 'string'),
                ],
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Updated')
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: '/api/admin/i18n/{id}',
        tags: ['Translations'],
        summary: 'Delete translation by id',
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(response: 200, description: 'Deleted')
        ]
    )]
    public function delete() {}

    #[OA\Post(
        path: '/api/admin/i18n/clear',
        tags: ['Translations'],
        summary: 'Clear i18n cache for {locale}/{namespace}/{group}',
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            content: new OA\JsonContent(
                type: 'object',
                properties: [
                    new OA\Property(property: 'locale', type: 'string', example: 'vi'),
                    new OA\Property(property: 'namespace', type: 'string', example: '*'),
                    new OA\Property(property: 'group', type: 'string', example: 'homepage'),
                ],
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'OK')
        ]
    )]
    public function clearCache() {}
}

<?php
/**
 * @OA\Info(
 *     title="Digita Marketing API",
 *     version="1.0.0",
 *     description="API pour la gestion des tâches marketing de Digita",
 *     @OA\Contact(
 *         email="contact@digita.fr",
 *         name="Support Digita"
 *     )
 * )
 */

/**
 * @OA\SecurityScheme(
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth"
 * )
 */

/**
 * @OA\Tag(
 *     name="Tasks",
 *     description="Endpoints pour la gestion des tâches"
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tasks",
 *     summary="Créer une nouvelle tâche",
 *     tags={"Tasks"},
 *     security={{"bearerAuth": {}}},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name", "type", "due_date"},
 *             @OA\Property(property="name", type="string", example="Campagne Facebook Q1"),
 *             @OA\Property(property="type", type="string", example="social_media"),
 *             @OA\Property(property="due_date", type="string", format="date", example="2025-03-01"),
 *             @OA\Property(property="priority", type="string", enum={"low", "medium", "high"}, example="high"),
 *             @OA\Property(property="description", type="string")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Tâche créée avec succès",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="message", type="string", example="Tâche créée avec succès")
 *         )
 *     ),
 *     @OA\Response(
 *         response=400,
 *         description="Données invalides"
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Non authentifié"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tasks/{id}",
 *     summary="Récupérer les détails d'une tâche",
 *     tags={"Tasks"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ID de la tâche",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Détails de la tâche",
 *         @OA\JsonContent(
 *             @OA\Property(property="id", type="integer"),
 *             @OA\Property(property="name", type="string"),
 *             @OA\Property(property="type", type="string"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="due_date", type="string", format="date"),
 *             @OA\Property(property="priority", type="string"),
 *             @OA\Property(property="created_at", type="string", format="datetime"),
 *             @OA\Property(property="updated_at", type="string", format="datetime")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Tâche non trouvée"
 *     )
 * )
 */

/**
 * @OA\Put(
 *     path="/api/tasks/{id}/status",
 *     summary="Mettre à jour le statut d'une tâche",
 *     tags={"Tasks"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"status"},
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 enum={"pending", "in_progress", "completed", "cancelled"},
 *                 example="completed"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Statut mis à jour"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/statistics/tasks",
 *     summary="Obtenir les statistiques des tâches",
 *     tags={"Statistics"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(
 *         name="start_date",
 *         in="query",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Parameter(
 *         name="end_date",
 *         in="query",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Statistiques des tâches",
 *         @OA\JsonContent(
 *             @OA\Property(property="total_tasks", type="integer"),
 *             @OA\Property(property="completed_tasks", type="integer"),
 *             @OA\Property(property="completion_rate", type="number", format="float"),
 *             @OA\Property(property="average_duration", type="number", format="float")
 *         )
 *     )
 * )
 */

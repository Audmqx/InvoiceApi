<?php

namespace App\Http\Controllers;

use App\UseCases\PaginatedInvoices;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API Documentation",
 *     version="1.0.0",
 *     description="API documentation for the Invoice system",
 *
 *     @OA\Contact(
 *         email="support@example.com"
 *     ),
 *
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\PathItem(
 *     path="/api/invoices"
 * )
 */
class InvoiceController extends Controller
{
    public function __construct(protected PaginatedInvoices $paginatedInvoices) {}

    /**
     * @OA\Get(
     *     path="/api/invoices",
     *     summary="Get paginated list of invoices",
     *     description="Returns a paginated list of invoices with associated invoice lines, ordered by sent_at (desc)",
     *     tags={"Invoices"},
     *
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Number of invoices to return per page",
     *         required=false,
     *
     *         @OA\Schema(type="integer", default=20)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="invoices", type="array",
     *
     *                 @OA\Items(
     *
     *                     @OA\Property(property="client", type="string", description="The client associated with the invoice"),
     *                     @OA\Property(property="number", type="string", description="The invoice number"),
     *                     @OA\Property(property="status", type="string", description="The status of the invoice", enum={"sent", "late", "paid", "cancelled"}),
     *                     @OA\Property(property="sent_at", type="string", format="date-time", description="When the invoice was sent"),
     *                     @OA\Property(property="paid_at", type="string", format="date-time", nullable=true, description="When the invoice was paid (nullable)"),
     *                     @OA\Property(property="total", type="number", format="float", description="The total amount of the invoice calculated from the lines"),
     *                     @OA\Property(property="invoice_lines", type="array", description="Lines associated with the invoice",
     *
     *                         @OA\Items(ref="#/components/schemas/InvoiceLine")
     *                     )
     *                 )
     *             ),
     *
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="total", type="integer"),
     *                 @OA\Property(property="current_page", type="integer"),
     *                 @OA\Property(property="per_page", type="integer"),
     *                 @OA\Property(property="last_page", type="integer")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="No invoices found",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="error", type="string", example="No invoices found")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->paginatedInvoices->execute()
            ->match(
                fn ($invoices) => response()->json($invoices),
                fn () => response()->json(['error' => 'No invoices found'], 404)
            );
    }
}

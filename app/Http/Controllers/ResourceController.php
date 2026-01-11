<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use App\Models\User;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function publicIndex(Request $request)
    {
        return $this->index($request, true);
    }

    public function index(Request $request, bool $public = false)
    {
        $q = Resource::query()->with('category', 'manager');

        if ($request->filled('category')) {
            $q->whereHas('category', fn($c) => $c->where('slug', $request->string('category')));
        }
        if ($request->filled('state')) {
            $q->where('state', $request->string('state'));
        }
        if ($request->filled('search')) {
            $s = '%'.$request->string('search').'%';
            $q->where('name', 'like', $s)->orWhere('location', 'like', $s);
        }

        if ($public) {
            // public can only see not-disabled
            $q->where('state', '!=', Resource::STATE_DISABLED);
        }

        $resources = $q->orderBy('name')->paginate(12)->withQueryString();
        $categories = ResourceCategory::orderBy('name')->get();

        return view('resources.index', compact('resources', 'categories', 'public'));
    }

    public function show(Resource $resource)
    {
        $resource->load('category', 'manager', 'maintenances');
        return view('resources.show', compact('resource'));
    }

    public function create()
    {
        $categories = ResourceCategory::orderBy('name')->get();
        $managers = \App\Models\User::query()->whereIn('role', [User::ROLE_MANAGER, User::ROLE_ADMIN])->orderBy('name')->get();
        return view('admin.resources.create', compact('categories', 'managers'));
    }

    public function store(Request $request, AuditLogger $logger)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'category_id' => ['required', 'exists:resource_categories,id'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'location' => ['nullable', 'string', 'max:190'],
            'state' => ['required', 'in:available,maintenance,disabled'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'specs' => ['nullable', 'array'],
            'specs.*' => ['nullable', 'string', 'max:190'],
        ]);

        $resource = Resource::create($data);
        $logger->log($request->user()->id, 'resource.create', Resource::class, $resource->id, $data);

        return redirect()->route('resources.show', $resource)->with('success', 'Ressource créée.');
    }

    public function edit(Resource $resource)
    {
        $this->authorize('update', $resource);

        $categories = ResourceCategory::orderBy('name')->get();
        $managers = \App\Models\User::query()->whereIn('role', [User::ROLE_MANAGER, User::ROLE_ADMIN])->orderBy('name')->get();
        return view('admin.resources.edit', compact('resource', 'categories', 'managers'));
    }

    public function update(Request $request, Resource $resource, AuditLogger $logger)
    {
        $this->authorize('update', $resource);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:190'],
            'category_id' => ['required', 'exists:resource_categories,id'],
            'manager_id' => ['nullable', 'exists:users,id'],
            'location' => ['nullable', 'string', 'max:190'],
            'state' => ['required', 'in:available,maintenance,disabled'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'specs' => ['nullable', 'array'],
            'specs.*' => ['nullable', 'string', 'max:190'],
        ]);

        $resource->update($data);
        $logger->log($request->user()->id, 'resource.update', Resource::class, $resource->id, $data);

        return redirect()->route('resources.show', $resource)->with('success', 'Ressource mise à jour.');
    }
}

@php($specs = old('specs', $resource?->specs ?? ['CPU'=>'','RAM'=>'','OS'=>'','Stockage'=>'','Bande passante'=>'']))

<div class="grid2">
  <label>Nom
    <input type="text" name="name" value="{{ old('name', $resource?->name) }}" required>
  </label>

  <label>Catégorie
    <select name="category_id" required>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected((int)old('category_id', $resource?->category_id)===(int)$c->id)>{{ $c->name }}</option>
      @endforeach
    </select>
  </label>
</div>

<div class="grid2">
  <label>Responsable
    <select name="manager_id">
      <option value="">—</option>
      @foreach($managers as $m)
        <option value="{{ $m->id }}" @selected((int)old('manager_id', $resource?->manager_id)===(int)$m->id)>{{ $m->name }}</option>
      @endforeach
    </select>
  </label>

  <label>État
    <select name="state" required>
      <option value="available" @selected(old('state', $resource?->state)==='available')>Disponible</option>
      <option value="maintenance" @selected(old('state', $resource?->state)==='maintenance')>Maintenance</option>
      <option value="disabled" @selected(old('state', $resource?->state)==='disabled')>Désactivée</option>
    </select>
  </label>
</div>

<label>Emplacement
  <input type="text" name="location" value="{{ old('location', $resource?->location) }}">
</label>

<label>Notes
  <textarea name="notes" rows="3">{{ old('notes', $resource?->notes) }}</textarea>
</label>

<h2>Spécifications</h2>
<div class="grid2">
  @foreach($specs as $k => $v)
    <label>{{ $k }}
      <input type="text" name="specs[{{ $k }}]" value="{{ $v }}">
    </label>
  @endforeach
</div>

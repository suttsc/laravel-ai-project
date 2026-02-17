<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use Illuminate\Support\Str;

new class extends Component
{
    public array $expenses = [
        ['id' => 'init-1', 'name' => 'Netflix', 'amount' => 15.99],
        ['id' => 'init-2', 'name' => 'Spotify', 'amount' => 10.99],
    ];

    public function addExpense(): void
    {
        $this->expenses[] = [
            'id' => Str::random(),
            'name' => '',
            'amount' => '',
        ];
    }

    public function removeExpense($id): void
    {
        $this->expenses = array_filter($this->expenses, fn ($e) => $e['id'] !== $id);
        $this->expenses = array_values($this->expenses);
    }

    #[Computed]
    public function totalMonthly(): float
    {
        return array_reduce($this->expenses, fn ($carry, $item) => $carry + (float) ($item['amount'] ?? 0), 0);
    }

    #[Computed]
    public function totalYearly(): float
    {
        return $this->totalMonthly * 12;
    }
};
?>

<div class="flex flex-col gap-6 w-full max-w-2xl mx-auto p-6 bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <flux:heading level="2" size="lg">Monthly Expenses</flux:heading>
            <flux:text>Add your subscriptions to see how much they cost you yearly.</flux:text>
        </div>
        <flux:button wire:click="addExpense" icon="plus" variant="primary" size="sm">Add Expense</flux:button>
    </div>

    <flux:separator />

    <div class="space-y-4">
        @if(empty($expenses))
            <div class="text-center py-12">
                <div class="mx-auto size-12 text-zinc-300 dark:text-zinc-600 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                    </svg>
                </div>
                <flux:text>No expenses added yet.</flux:text>
                <div class="mt-4">
                     <flux:button wire:click="addExpense" variant="subtle" size="sm">Add your first expense</flux:button>
                </div>
            </div>
        @else
            @foreach($expenses as $index => $expense)
                <div class="flex gap-3 items-start" wire:key="expense-{{ $expense['id'] }}">
                    <div class="grow">
                        <flux:input wire:model="expenses.{{ $index }}.name" placeholder="Name" aria-label="Expense Name" />
                    </div>
                    <div class="w-32 shrink-0">
                        <flux:input type="number" wire:model.live="expenses.{{ $index }}.amount" placeholder="0.00" icon="currency-dollar" aria-label="Amount" />
                    </div>
                    <flux:button wire:click="removeExpense('{{ $expense['id'] }}')" icon="trash" variant="danger" class="!px-3" aria-label="Remove" />
                </div>
            @endforeach
        @endif
    </div>

    <flux:separator />

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="p-4 bg-zinc-50 dark:bg-zinc-900/50 rounded-lg border border-zinc-200 dark:border-zinc-800">
            <div class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Monthly</div>
            <div class="text-3xl font-bold text-zinc-900 dark:text-white mt-1 tracking-tight">
                ${{ number_format($this->totalMonthly, 2) }}
            </div>
        </div>
        <div class="p-4 bg-zinc-900 dark:bg-white rounded-lg border border-zinc-900 dark:border-white text-white dark:text-zinc-900">
            <div class="text-sm font-medium opacity-80">Total Yearly</div>
            <div class="text-3xl font-bold mt-1 tracking-tight">
                ${{ number_format($this->totalYearly, 2) }}
            </div>
        </div>
    </div>
</div>

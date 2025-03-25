<?php namespace Vankosoft\ApplicationBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\Markup;
use Vankosoft\ApplicationBundle\Component\ProjectIssue\KanbanboardTask;

final class KanbanBoardTaskExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter( 'vs_kanbanboard_task_priority', [$this, 'priority'] ),
            new TwigFilter( 'vs_kanbanboard_task_status', [$this, 'status'] ),
        ];
    }
    
    public function priority( string $priority ): Markup
    {
        $priorityHtml = 'UNDEFINED';
        switch ( $priority ) {
            case KanbanboardTask::TASK_PRIORITY_LOW:
                $priorityHtml = \sprintf( '<span class="badge bg-success">%s</span>',
                    KanbanboardTask::TASK_PRIORITIES[KanbanboardTask::TASK_PRIORITY_LOW]
                );
                break;
            case KanbanboardTask::TASK_PRIORITY_MEDIUM:
                $priorityHtml = \sprintf( '<span class="badge bg-warning text-warning">%s</span>',
                    KanbanboardTask::TASK_PRIORITIES[KanbanboardTask::TASK_PRIORITY_MEDIUM]
                );
                break;
            case KanbanboardTask::TASK_PRIORITY_HIGH:
                $priorityHtml = \sprintf( '<span class="badge bg-danger-subtle text-danger">%s</span>',
                    KanbanboardTask::TASK_PRIORITIES[KanbanboardTask::TASK_PRIORITY_HIGH]
                );
                break;
        }
        
        return new Markup( $priorityHtml, 'UTF-8' );
    }
    
    public function status( string $status ): Markup
    {
        $statusHtml = 'UNDEFINED';
        switch ( $status ) {
            case KanbanboardTask::TASK_STATUS_NEW:
                $statusHtml = \sprintf( '<span class="badge bg-info-subtle text-info">%s</span>',
                    KanbanboardTask::TASK_STATUSES[KanbanboardTask::TASK_STATUS_NEW]
                );
                break;
            case KanbanboardTask::TASK_STATUS_INPROGRESS:
                $statusHtml = \sprintf( '<span class="badge bg-secondary-subtle text-secondary">%s</span>',
                    KanbanboardTask::TASK_STATUSES[KanbanboardTask::TASK_STATUS_INPROGRESS]
                );
                break;
            case KanbanboardTask::TASK_STATUS_COMPLETED:
                $statusHtml = \sprintf( '<span class="badge bg-success-subtle text-success">%s</span>',
                    KanbanboardTask::TASK_STATUSES[KanbanboardTask::TASK_STATUS_COMPLETED]
                );
                break;
            case KanbanboardTask::TASK_STATUS_PENDING:
                $statusHtml = \sprintf( '<span class="badge bg-warning-subtle text-warning">%s</span>',
                    KanbanboardTask::TASK_STATUSES[KanbanboardTask::TASK_STATUS_PENDING]
                );
                break;
        }
        
        return new Markup( $statusHtml, 'UTF-8' );
    }
}
